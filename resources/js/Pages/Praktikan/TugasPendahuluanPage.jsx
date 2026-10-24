import { useCallback, useEffect, useMemo, useState } from "react";
import { Head, usePage } from "@inertiajs/react";
import { useMutation, useQuery } from "@tanstack/react-query";
import toast from "react-hot-toast";
import PraktikanAuthenticated from "@/Layouts/PraktikanAuthenticatedLayout";
import PraktikanUtilities from "@/Components/Praktikans/Layout/PraktikanUtilities";
import TugasPendahuluan from "@/Components/Praktikans/Sections/TugasPendahuluan";
import PraktikanPageHeader from "@/Components/Praktikans/Common/PraktikanPageHeader";
import { useModulesQuery } from "@/hooks/useModulesQuery";
import {
    useTugasPendahuluanQuery,
} from "@/hooks/useTugasPendahuluanQuery";
import { api } from "@/lib/api";

const normaliseModuleId = (module) => Number(module?.idM ?? module?.id ?? module?.modul_id ?? 0);

const normaliseQuestions = (items) =>
    (items ?? [])
        .filter((item) => item && (item.soal || item.pertanyaan))
        .map((item) => ({
            id: item.id,
            text: item.soal ?? item.pertanyaan ?? "",
            questionType: "essay",
            enable_file_upload: Boolean(item.enable_file_upload),
        }));

const isLikelyJsonObjectString = (value) => {
    if (typeof value !== "string") {
        return false;
    }

    const trimmed = value.trim();

    if (trimmed === "") {
        return false;
    }

    return (
        (trimmed.startsWith("{") && trimmed.endsWith("}")) ||
        (trimmed.startsWith("[") && trimmed.endsWith("]"))
    );
};

const hydrateAnswer = (storedAnswer) => {
    if (storedAnswer === null || storedAnswer === undefined) {
        return "";
    }

    if (typeof storedAnswer === "object") {
        return storedAnswer;
    }

    if (typeof storedAnswer !== "string") {
        return String(storedAnswer ?? "");
    }

    const trimmed = storedAnswer.trim();

    if (trimmed === "") {
        return "";
    }

    if (isLikelyJsonObjectString(trimmed)) {
        try {
            const parsed = JSON.parse(trimmed);

            if (parsed && typeof parsed === "object") {
                return parsed;
            }
        } catch (error) {
            console.warn(
                "[TP] Failed to parse stored answer",
                error
            );
        }
    }

    return storedAnswer;
};

const serialiseAnswerForSubmission = (answerValue) => {
    if (answerValue === null || answerValue === undefined) {
        return "";
    }

    if (typeof answerValue === "object") {
        try {
            return JSON.stringify(answerValue);
        } catch (error) {
            console.warn(
                "[TP] Failed to stringify answer",
                error
            );

            return "";
        }
    }

    if (typeof answerValue === "string") {
        return answerValue;
    }

    return String(answerValue ?? "");
};

export default function TugasPendahuluanPage() {
    const { auth } = usePage().props ?? {};
    const praktikan = auth?.praktikan ?? null;
    const praktikanId = praktikan?.id ?? null;

    const kelasName = (praktikan?.kelas?.kelas ?? "").toString();
    const isTotClass = kelasName.toUpperCase().startsWith("TOT");
    const isEnglishClass = Boolean(praktikan?.kelas?.isEnglish);

    const modulesQuery = useModulesQuery({
        onError: (error) => {
            toast.error(error?.message ?? "Gagal memuat daftar modul.");
        },
    });

    const tugasQuery = useTugasPendahuluanQuery({
        onError: (error) => {
            toast.error(error?.message ?? "Gagal memuat konfigurasi tugas pendahuluan.");
        },
    });

    const modules = modulesQuery.data ?? [];
    const tugasPendahuluanPayload = tugasQuery.data ?? { items: [], meta: {} };
    const tugasPendahuluan = tugasPendahuluanPayload.items ?? [];
    const tugasMeta = tugasPendahuluanPayload.meta ?? {};
    const isTpGloballyActive = tugasMeta.tp_active === undefined ? true : Boolean(tugasMeta.tp_active);

    const moduleMap = useMemo(
        () => new Map(modules.map((module) => [normaliseModuleId(module), module])),
        [modules]
    );

    const praktikanKelasId = praktikan?.kelas_id ?? praktikan?.kelas?.id ?? null;

    const fallbackActiveModuleEntry = useMemo(() => {
        if (!Array.isArray(tugasPendahuluan) || tugasPendahuluan.length === 0) {
            return null;
        }

        // Find all modules that are active for this praktikan's class
        const activeForClass = tugasPendahuluan.filter((item) => {
            if (!item.isActive) {
                return false;
            }

            // Check class-specific activation
            const activeKelasIds = item.active_kelas_ids ?? [];
            return activeKelasIds.length === 0 ||
                (praktikanKelasId && activeKelasIds.includes(Number(praktikanKelasId)));
        });

        if (activeForClass.length === 0) {
            return null;
        }

        // Prefer module matching the class type (English/Regular), but accept any
        const preferredModule = activeForClass.find((item) => {
            const module = moduleMap.get(Number(item.modul_id));
            const isEnglishModule = Number(module?.isEnglish ?? 0) === 1;
            return isEnglishClass ? isEnglishModule : !isEnglishModule;
        });

        return preferredModule ?? activeForClass[0];
    }, [tugasPendahuluan, moduleMap, isEnglishClass, praktikanKelasId]);

    const defaultModuleId = fallbackActiveModuleEntry ? Number(fallbackActiveModuleEntry.modul_id) : null;
    const activeModule = defaultModuleId ? moduleMap.get(defaultModuleId) ?? null : null;

    const [selectedModul, setSelectedModul] = useState(defaultModuleId ? String(defaultModuleId) : "");

    useEffect(() => {
        setSelectedModul(defaultModuleId ? String(defaultModuleId) : "");
    }, [defaultModuleId]);

    useEffect(() => {
        if (!selectedModul) {
            setQuestions([]);
            setAnswers([]);
        }
    }, [selectedModul]);

    const questionsQuery = useQuery({
        queryKey: ["tp-questions", selectedModul],
        enabled: Boolean(selectedModul),
        queryFn: async () => {
            try {
                const { data } = await api.get(`/api-v1/soal-tp/${selectedModul}`);
                if (Array.isArray(data?.data)) {
                    return normaliseQuestions(data.data);
                }
                if (Array.isArray(data)) {
                    return normaliseQuestions(data);
                }
                return [];
            } catch (error) {
                if (error?.response?.status === 404) {
                    return [];
                }
                throw error;
            }
        },
    });

    const answersQuery = useQuery({
        queryKey: ["tp-answers", selectedModul],
        enabled: Boolean(selectedModul),
        queryFn: async () => {
            const { data } = await api.get(`/api-v1/jawaban-tp/${selectedModul}`);
            if (Array.isArray(data?.jawaban_tp)) {
                return data.jawaban_tp;
            }
            return [];
        },
    });

    const [questions, setQuestions] = useState([]);
    const [answers, setAnswers] = useState([]);

    useEffect(() => {
        const data = questionsQuery.data ?? [];
        setQuestions(data);
    }, [questionsQuery.data]);

    useEffect(() => {
        const data = questionsQuery.data ?? [];
        const storedAnswers = answersQuery.data ?? [];
        const answerMap = new Map(
            storedAnswers.map((item) => [Number(item?.soal_id), item?.jawaban ?? ""])
        );

        const initialAnswers = data.map((question) => {
            const storedAnswer = answerMap.get(Number(question.id));
            return hydrateAnswer(storedAnswer);
        });
        setAnswers(initialAnswers);
    }, [answersQuery.data, questionsQuery.data]);

    const submitMutation = useMutation({
        mutationFn: async (payload) => {
            const { data } = await api.post("/api-v1/jawaban-tp", payload);
            return data;
        },
        onSuccess: () => {
            toast.success("Jawaban berhasil disimpan.");
            answersQuery.refetch();
        },
        onError: (error) => {
            toast.error(error?.response?.data?.message ?? error?.message ?? "Gagal menyimpan jawaban.");
        },
    });

    const handleSubmitTask = useCallback(
        (taskName, currentAnswers) => {
            if (taskName !== "TugasPendahuluan" || !praktikanId) {
                return;
            }

            if (!selectedModul) {
                toast.error("Tidak ada modul tugas pendahuluan yang aktif saat ini.");
                return;
            }

            const payload = questions.map((question, index) => ({
                soal_id: Number(question.id),
                praktikan_id: praktikanId,
                modul_id: Number(selectedModul),
                jawaban: serialiseAnswerForSubmission(currentAnswers[index]) || "-",
            }));

            submitMutation.mutate(payload);
        },
        [praktikanId, selectedModul, questions, submitMutation]
    );

    const handleQuestionsCount = useCallback(() => { }, []);

    const blockClipboardEvent = useCallback((event) => {
        event.preventDefault();
        toast.error("Copy, paste, dan cut dinonaktifkan pada halaman ini.");
    }, []);

    const renderPlaceholder = (message) => (
        <div className="min-h-[70vh] mx-auto mt-2">
            <div className="mt-[25vh] flex-col gap-2 items-center justify-center p-8 text-center text-sm font-semibold text-depth-secondary">
                <svg className="mx-auto mb-4 h-24 w-24 text-gray-300" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="40" stroke="currentColor" strokeWidth="2" strokeDasharray="4 4" />
                    <circle cx="50" cy="50" r="30" stroke="currentColor" strokeWidth="2" strokeDasharray="3 3" />
                    <circle cx="50" cy="50" r="20" stroke="currentColor" strokeWidth="2" strokeDasharray="2 2" />
                    <path d="M30 50 Q35 40, 40 50 T50 50" stroke="currentColor" strokeWidth="1.5" fill="none" />
                    <path d="M50 30 Q60 35, 50 40 T50 50" stroke="currentColor" strokeWidth="1.5" fill="none" />
                    <path d="M70 50 Q65 60, 60 50 T50 50" stroke="currentColor" strokeWidth="1.5" fill="none" />
                    <path d="M50 70 Q40 65, 50 60 T50 50" stroke="currentColor" strokeWidth="1.5" fill="none" />
                </svg>
                {message}
            </div>
        </div>
    );

    return (
        <>
            <PraktikanAuthenticated
                praktikan={praktikan}
                customWidth="w-[90%]"
                header={
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Dashboard
                    </h2>
                }
            >
                <Head title="Tugas Pendahuluan" />

                <div
                    className="mt-1 flex flex-col gap-1 select-none"
                    onCopy={blockClipboardEvent}
                    onCut={blockClipboardEvent}
                    onPaste={blockClipboardEvent}
                    onContextMenu={blockClipboardEvent}
                >
                    <PraktikanPageHeader title="Tugas Pendahuluan" />

                    {tugasQuery.isLoading
                        ? renderPlaceholder("Memuat konfigurasi tugas pendahuluan...")
                        : !isTpGloballyActive
                            ? renderPlaceholder("Tidak Ada Tugas Pendahuluan Saat Ini")
                            : !fallbackActiveModuleEntry
                                ? renderPlaceholder("Tidak Ada Tugas Pendahuluan Untuk Kelas Anda")
                                : (
                                    <TugasPendahuluan
                                        isLoading={questionsQuery.isLoading}
                                        errorMessage={questionsQuery.isError ? (questionsQuery.error?.message ?? "Gagal memuat soal.") : null}
                                        questions={questions}
                                        answers={answers}
                                        setAnswers={setAnswers}
                                        setQuestionsCount={handleQuestionsCount}
                                        onSubmitTask={handleSubmitTask}
                                        tipeSoal="tp"
                                        praktikanId={praktikanId}
                                        isCommentEnabled={isTotClass}
                                        showSubmitButton={Boolean(selectedModul)}
                                        submitLabel={submitMutation.isPending ? "Menyimpan..." : "Simpan Jawaban"}
                                    />
                                )}
                </div>
            </PraktikanAuthenticated>
            <PraktikanUtilities />
        </>
    );
}
