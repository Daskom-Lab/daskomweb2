import { useEffect, useMemo, useRef, useState } from "react";
import { useQuery } from "@tanstack/react-query";
import toast from "react-hot-toast";

import { api } from "@/lib/api";
import { send } from "@/lib/http";
import { store as storeNilai, update as updateNilai } from "@/lib/routes/nilai";
import { ModalOverlay } from "@/Components/Common/ModalPortal";
import ModalCloseButton from "@/Components/Common/ModalCloseButton";
import MarkdownRenderer from "../../MarkdownRenderer";
import PairNavigator from "./PairNavigator.jsx"

const SCORES = [
    ["tp", "TP"], ["ta", "TA"], ["d1", "D1"], ["d2", "D2"],
    ["d3", "D3"], ["d4", "D4"], ["l1", "I1"], ["l2", "I2"],
];

const TABS = [
    { key: "tp", label: "Tugas Pendahuluan", needsNim: true },
    { key: "ta", label: "Tes Awal" },
    { key: "jurnal", label: "Jurnal" },
    { key: "fitb", label: "FITB" },
    { key: "mandiri", label: "Mandiri" },
    { key: "tk", label: "Tes Keterampilan" },
];

const CONFIG = {
    ta: ["jawaban-ta", "jawaban_ta"],
    jurnal: ["jawaban-jurnal", "jawaban_jurnal"],
    fitb: ["jawaban-fitb", "jawaban_fitb"],
    mandiri: ["jawaban-mandiri", "jawaban_mandiri"],
    tk: ["jawaban-tk", "jawaban_tk"],
};

const clamp = (v, min, max) => {
    const n = Number(v);
    return Number.isNaN(n) ? min : Math.min(Math.max(n, min), max);
};

const clampScore = (v) => clamp(v, 0, 100);
const clampRating = (v) =>
    v === "" || v == null ? null : Number(clamp(v, 0.1, 5).toFixed(1));

const isImage = (url) =>
    typeof url === "string" &&
    /\.(jpe?g|png|gif|bmp|webp|svg)$/i.test(url.split(/[?#]/)[0]);

const parseAttachment = (entry) => {
    const raw = typeof entry?.jawaban === "string" ? entry.jawaban : "";
    const answer = raw === "-" ? "" : raw;
    const direct = entry?.attachment_url?.trim?.();

    if (direct) return { answer, url: direct };

    if (/^\s*[\[{]/.test(answer)) {
        try {
            const data = JSON.parse(answer);
            const url =
                data?.url ??
                data?.attachment_url ??
                data?.fileUrl ??
                data?.file_url;

            if (url)
                return {
                    answer: data?.answer ?? data?.caption ?? "",
                    url,
                };
        } catch {}
    }

    return { answer, url: null };
};

const normalize = (type, item, index) => {
    const supportsAttachment = ["tp", "jurnal", "fitb"].includes(type);
    const attachment = supportsAttachment ? parseAttachment(item) : null;
    const pg = type === "ta" || type === "tk";

    return {
        soalId: item.soal_id ?? item.soal_id ?? index,
        question: item.soal_text ?? item.pertanyaan ?? "Soal tidak tersedia",
        answer: pg
            ? null
            : attachment
              ? attachment.answer
              : typeof item.jawaban === "string"
                ? item.jawaban
                : "-",
        attachmentUrl: attachment?.url ?? null,
        options: pg && Array.isArray(item.options) ? item.options : [],
        selectedOptionId: pg ? item.selected_opsi_id ?? null : null,
        correctOptionId: pg ? item.opsi_benar_id ?? null : null,
    };
};

async function fetchAnswers(type, praktikan, modul) {
    if (type === "tp") {
        if (!praktikan?.nim) throw new Error("NIM praktikan tidak ditemukan.");

        const { data } = await api.get(
            `/api-v1/jawaban-tp/${praktikan.nim}/${modul.id}`,
        );

        if (data?.success === false)
            throw new Error(data?.message ?? "Gagal memuat jawaban TP.");

        const items = Array.isArray(data?.data?.jawabanData)
            ? data.data.jawabanData
            : [];

        return {
            questions: items.map((x, i) => normalize(type, x, i)),
            notice: data?.message,
        };
    }

    if (!praktikan?.id) throw new Error("Praktikan tidak ditemukan.");

    const [endpoint, key] = CONFIG[type] ?? [];
    if (!endpoint) return { questions: [] };

    const { data } = await api.get(
        `/api-v1/${endpoint}/praktikan/${praktikan.id}/modul/${modul.id}`,
    );

    if (data?.success === false)
        throw new Error(data?.message ?? "Gagal memuat jawaban.");

    const items = Array.isArray(data?.[key]) ? data[key] : [];

    return {
        questions: items.map((x, i) => normalize(type, x, i)),
        notice: data?.message,
    };
}

async function fetchAutoScore(type, praktikanId, modulId) {
    const [, key] = CONFIG[type];

    const { data } = await api.get(
        `/api-v1/jawaban-${type}/praktikan/${praktikanId}/modul/${modulId}`,
    );

    const items = Array.isArray(data?.[key]) ? data[key] : [];

    if (!items.length) return { score: 0, hasAnswers: false, answered: 0, total: 0 };

    const answered = items.filter(
        (x) =>
            x.selected_opsi_id !== null &&
            x.selected_opsi_id !== undefined &&
            x.selected_opsi_id !== "",
    );

    const total = Number(data?.total_questions ?? items.length);
    const correct = Number(
        data?.correct_answers ??
            answered.filter(
                (x) => String(x.selected_opsi_id) === String(x.opsi_benar_id),
            ).length,
    );

    return {
        score: total > 0 ? Math.round((correct / total) * 10000) / 100 : 0,
        hasAnswers: answered.length > 0,
        answered: answered.length,
        total,
    };
}

export default function ModalInputNilai({
    onClose,
    assignment,
    asistenId,
    onSaved,
}) {
    const bodyRef = useRef(null);

    const [scores, setScores] = useState({
        tp: 0, ta: 0, d1: 0, d2: 0,
        d3: 0, d4: 0, l1: 0, l2: 0,
    });
    const [activeTab, setActiveTab] = useState(null);
    const [activeQuestion, setActiveQuestion] = useState(0);
    const [rating, setRating] = useState(null);
    const [isSaving, setIsSaving] = useState(false);

    const nilai = assignment?.nilai ?? null;
    const praktikan = assignment?.praktikan ?? null;
    const modul = assignment?.modul ?? null;
    const kelas = praktikan?.kelas ?? null;

    const tabs = useMemo(
        () =>
            !modul?.id
                ? []
                : TABS.filter((x) =>
                      x.needsNim
                          ? Boolean(praktikan?.nim)
                          : Boolean(praktikan?.id),
                  ),
        [modul?.id, praktikan?.id, praktikan?.nim],
    );

    useEffect(() => {
        if (!tabs.length) return setActiveTab(null);
        if (!tabs.some((x) => x.key === activeTab)) setActiveTab(tabs[0].key);
    }, [tabs, activeTab]);

    useEffect(() => {
        setActiveQuestion(0);
        if (bodyRef.current) bodyRef.current.scrollTop = 0;
    }, [activeTab]);

    const {
        data: result,
        isLoading,
        isError,
        error,
        refetch,
    } = useQuery({
        queryKey: [
            "assistant-answers",
            activeTab,
            praktikan?.id,
            praktikan?.nim,
            modul?.id,
        ],
        enabled: Boolean(activeTab && modul?.id),
        retry: (count, err) =>
            err?.response?.status === 404 ? false : count < 2,
        queryFn: async () => {
            try {
                return await fetchAnswers(activeTab, praktikan, modul);
            } catch (err) {
                if (err?.response?.status === 404)
                    return {
                        questions: [],
                        notice:
                            err?.response?.data?.message ??
                            "Jawaban tidak ditemukan.",
                    };

                throw err;
            }
        },
    });

    const questions = result?.questions ?? [];

    useEffect(() => {
        setActiveQuestion((x) =>
            questions.length ? Math.min(x, questions.length - 1) : 0,
        );
    }, [questions.length]);

    const canAutoScore = Boolean(praktikan?.id && modul?.id);

    const { data: taScore } = useQuery({
        queryKey: ["ta-auto-score", praktikan?.id, modul?.id],
        enabled: canAutoScore,
        staleTime: 300000,
        retry: 1,
        queryFn: () => fetchAutoScore("ta", praktikan.id, modul.id),
    });

    const { data: tkScore } = useQuery({
        queryKey: ["tk-auto-score", praktikan?.id, modul?.id],
        enabled: canAutoScore,
        staleTime: 300000,
        retry: 1,
        queryFn: () => fetchAutoScore("tk", praktikan.id, modul.id),
    });

    useEffect(() => {
        setScores(
            nilai
                ? {
                      tp: clampScore(nilai.tp),
                      ta: clampScore(nilai.ta),
                      d1: clampScore(nilai.d1),
                      d2: clampScore(nilai.d2),
                      d3: clampScore(nilai.d3),
                      d4: clampScore(nilai.d4),
                      l1: clampScore(nilai.l1 ?? nilai.i1),
                      l2: clampScore(nilai.l2 ?? nilai.i2),
                  }
                : {
                      tp: 0, ta: 0, d1: 0, d2: 0,
                      d3: 0, d4: 0, l1: 0, l2: 0,
                  },
        );

        setRating(nilai ? clampRating(nilai.rating) : null);
    }, [nilai]);

    useEffect(() => {
        if (taScore?.hasAnswers)
            setScores((x) => ({ ...x, ta: clampScore(taScore.score) }));
    }, [taScore]);

    useEffect(() => {
        if (tkScore?.hasAnswers)
            setScores((x) => ({ ...x, l1: clampScore(tkScore.score) }));
    }, [tkScore]);

    const average = useMemo(
        () =>
            Number(
                (
                    SCORES.reduce(
                        (sum, [key]) => sum + clampScore(scores[key]),
                        0,
                    ) / SCORES.length
                ).toFixed(2),
            ),
        [scores],
    );

    const goToQuestion = (index) => {
        if (index < 0 || index >= questions.length) return;

        setActiveQuestion(index);

        requestAnimationFrame(() => {
            const body = bodyRef.current;
            const target = document.getElementById(
                `nilai-soal-${activeTab}-${index}`,
            );

            if (!body || !target) return;

            body.scrollTo({
                top:
                    body.scrollTop +
                    target.getBoundingClientRect().top -
                    body.getBoundingClientRect().top -
                    70,
                behavior: "smooth",
            });
        });
    };

    const handleSubmit = () => {
        if (!asistenId)
            return toast.error("Data asisten tidak ditemukan.");

        if (!praktikan?.id || !modul?.id || !kelas?.id)
            return toast.error("Data praktikan tidak lengkap.");

        if (rating !== null && (rating < 0.1 || rating > 5))
            return toast.error("Rating harus antara 0.1 hingga 5.0.");

        setIsSaving(true);

        send(
            nilai?.id ? updateNilai(nilai.id) : storeNilai(),
            {
                ...scores,
                modul_id: modul.id,
                asisten_id: asistenId,
                kelas_id: kelas.id,
                praktikan_id: praktikan.id,
                rating,
            },
        )
            .then(() => {
                toast.success("Nilai berhasil disimpan 🎉");
                onSaved?.();
            })
            .catch((err) =>
                toast.error(
                    err?.response?.data?.message ??
                        "Terjadi kesalahan saat menyimpan nilai.",
                ),
            )
            .finally(() => setIsSaving(false));
    };

    const currentAutoScore =
        activeTab === "ta" ? taScore : activeTab === "tk" ? tkScore : null;

    return (
        <ModalOverlay
            onClose={onClose}
            className="depth-modal-overlay z-50"
            style={{ padding: 0 }}
        >
            <div className="pointer-events-none flex h-full w-full items-center justify-center px-2 py-4 sm:py-6">
                <div
                    className="depth-modal-container pointer-events-auto flex max-h-[90vh] w-full max-w-[95vw] flex-col overflow-hidden"
                    style={{ "--depth-modal-max-width": "95vw" }}
                >
                    {/* Fixed header */}
                    <header className="relative shrink-0 border-b border-depth pb-5 text-center">
                        <ModalCloseButton
                            onClick={onClose}
                            ariaLabel="Tutup input nilai"
                            className="absolute -top-2 right-0"
                        />

                        <h2 className="text-2xl font-semibold">
                            {nilai ? "Perbarui Nilai" : "Input Nilai"}
                        </h2>

                        <p className="mt-2 text-sm text-depth-secondary">
                            {praktikan?.nama ?? "Praktikan"} (
                            {praktikan?.nim ?? "-"}) ·{" "}
                            {modul?.judul ?? "Modul tidak dikenal"}
                        </p>
                    </header>

                    {/* Scrollable body */}
                    <div
                        ref={bodyRef}
                        className="min-h-0 flex-1 overflow-y-auto py-5 pr-1 sm:pr-2"
                    >
                        <div className="space-y-6">
                            {/* Scores */}
                            <div className="grid grid-cols-2 gap-4 sm:grid-cols-5 lg:grid-cols-10">
                                {SCORES.map(([key, label]) => (
                                    <label
                                        key={key}
                                        className="flex flex-col gap-1 text-xs font-semibold"
                                    >
                                        {label}

                                        <input
                                            type="number"
                                            min={0}
                                            max={100}
                                            value={scores[key]}
                                            onChange={(e) =>
                                                setScores((x) => ({
                                                    ...x,
                                                    [key]: clampScore(
                                                        e.target.value,
                                                    ),
                                                }))
                                            }
                                            onWheel={(e) => e.target.blur()}
                                            className="h-10 rounded-depth-md border border-depth bg-depth-card p-2 text-center text-sm"
                                        />
                                    </label>
                                ))}

                                <label className="flex flex-col gap-1 text-xs font-semibold">
                                    Rata-rata
                                    <input
                                        readOnly
                                        value={average}
                                        className="h-10 rounded-depth-md border border-depth bg-depth-card p-2 text-center text-sm"
                                    />
                                </label>

                                <label className="flex flex-col gap-1 text-xs font-semibold">
                                    Rating
                                    <input
                                        type="number"
                                        min={0.1}
                                        max={5}
                                        step={0.1}
                                        value={rating ?? ""}
                                        onChange={(e) =>
                                            setRating(
                                                clampRating(e.target.value),
                                            )
                                        }
                                        onWheel={(e) => e.target.blur()}
                                        className="h-10 rounded-depth-md border border-depth bg-depth-card p-2 text-center text-sm"
                                    />

                                    <input
                                        type="range"
                                        min={0.1}
                                        max={5}
                                        step={0.1}
                                        value={rating ?? 0.1}
                                        onChange={(e) =>
                                            setRating(
                                                clampRating(e.target.value),
                                            )
                                        }
                                    />
                                </label>
                            </div>

                            {/* Category tabs */}
                            <div className="flex flex-wrap gap-2">
                                {tabs.map((tab) => (
                                    <button
                                        key={tab.key}
                                        type="button"
                                        onClick={() => setActiveTab(tab.key)}
                                        className={`rounded-depth-full border px-4 py-1.5 text-sm font-semibold transition ${
                                            activeTab === tab.key
                                                ? "border-[var(--depth-color-primary)] bg-[var(--depth-color-primary)]/15 text-[var(--depth-color-primary)]"
                                                : "border-depth bg-depth-interactive"
                                        }`}
                                    >
                                        {tab.label}
                                    </button>
                                ))}
                            </div>

                            {/* Questions */}
                            {isLoading ? (
                                <div className="py-10 text-center">
                                    Memuat jawaban...
                                </div>
                            ) : isError ? (
                                <div className="rounded-depth-md border border-rose-500/40 bg-rose-500/10 p-4 text-sm text-rose-200">
                                    {error?.response?.data?.message ??
                                        error?.message ??
                                        "Gagal memuat jawaban."}

                                    <button
                                        type="button"
                                        onClick={() => refetch()}
                                        className="ml-3 font-semibold underline"
                                    >
                                        Coba Lagi
                                    </button>
                                </div>
                            ) : !questions.length ? (
                                <div className="rounded-depth-md border border-depth bg-depth-interactive p-6 text-sm text-depth-secondary">
                                    {result?.notice ??
                                        "Belum ada jawaban yang disubmit."}
                                </div>
                            ) : (
                                <div className="space-y-4">
                                    {/* Sticky question navbar */}
                                    <div className="sticky top-0 z-20 pb-2">
                                        <PairNavigator
                                            count={questions.length}
                                            active={activeQuestion}
                                            onChange={goToQuestion}
                                        />
                                    </div>

                                    {questions.map((item, index) => {
                                        const hasOptions = item.options.length > 0;
                                        const answer =
                                            typeof item.answer === "string"
                                                ? item.answer
                                                : "";
                                        const hasAnswer =
                                            answer.trim() &&
                                            answer.trim() !== "-";
                                        const isUnanswered =
                                            hasOptions &&
                                            !item.selectedOptionId;

                                        return (
                                            <article
                                                key={item.soalId ?? index}
                                                id={`nilai-soal-${activeTab}-${index}`}
                                                className="rounded-depth-lg border border-depth bg-depth-card p-4 shadow-depth-sm"
                                            >
                                                <div className="flex items-start gap-3">
                                                    <span
                                                        className={`flex h-7 min-w-7 items-center justify-center rounded-depth-full text-xs font-bold text-white ${
                                                            isUnanswered
                                                                ? "bg-amber-500"
                                                                : String(item.selectedOptionId) !== String(item.correctOptionId)
                                                                    ? "bg-red-500"
                                                                    : "bg-[var(--depth-color-primary)]"
                                                        }`}
                                                    >
                                                        {index + 1}
                                                    </span>

                                                    <div className="min-w-0 flex-1">
                                                        <MarkdownRenderer
                                                            content={item.question}
                                                            className="[&>*:first-child]:mt-0 [&>*:last-child]:mb-0"
                                                        />

                                                        {isUnanswered && (
                                                            <div className="mt-2 inline-flex rounded-depth-full border border-amber-400/40 bg-amber-400/10 px-2.5 py-1 text-xs font-semibold text-amber-400">
                                                                Tidak Dijawab
                                                            </div>
                                                        )}
                                                        {String(item.selectedOptionId) !== String(item.correctOptionId) && !isUnanswered && (
                                                            <div className="mt-2 inline-flex rounded-depth-full border border-red-500/40 bg-red-500/10 px-2.5 py-1 text-xs font-semibold text-red-500">
                                                                Jawaban Salah
                                                            </div>
                                                        )}
                                                        {!isUnanswered && String(item.selectedOptionId) === String(item.correctOptionId) && (
                                                            <div className="mt-2 inline-flex rounded-depth-full border border-[#4c7a4c]/40 bg-[var(--depth-color-primary)]/10 px-2.5 py-1 text-xs font-semibold bg-[var(--depth-color-primary)]">
                                                                Jawaban Benar
                                                            </div>
                                                        )}
                                                    </div>
                                                </div>

                                                {hasOptions ? (
                                                    <ul className="mt-4 space-y-3">
                                                        {item.options.map(
                                                            (option, i) => {
                                                                const selected =
                                                                    String(
                                                                        item.selectedOptionId ??
                                                                            "",
                                                                    ) ===
                                                                    String(
                                                                        option?.id ??
                                                                            "",
                                                                    );

                                                                const correct =
                                                                    Boolean(
                                                                        option?.is_correct,
                                                                    ) ||
                                                                    String(
                                                                        item.correctOptionId ??
                                                                            "",
                                                                    ) ===
                                                                        String(
                                                                            option?.id ??
                                                                                "",
                                                                        );

                                                                return (
                                                                    <li
                                                                        key={
                                                                            option?.id ??
                                                                            i
                                                                        }
                                                                        className={`rounded-depth-md border p-3 ${
                                                                            correct
                                                                                ? "border-[var(--depth-color-primary)] bg-[var(--depth-color-primary)]/10"
                                                                                : selected
                                                                                  ? "border-amber-400/70 bg-amber-400/15"
                                                                                  : "border-depth bg-depth-interactive"
                                                                        }`}
                                                                    >
                                                                        <div className="flex items-start justify-between gap-3">
                                                                            <div className="min-w-0 flex-1">
                                                                                <MarkdownRenderer
                                                                                    content={
                                                                                        option?.text ??
                                                                                        ""
                                                                                    }
                                                                                    className="text-sm [&>*:first-child]:mt-0 [&>*:last-child]:mb-0"
                                                                                />
                                                                            </div>

                                                                            <div className="flex shrink-0 gap-1">
                                                                                {correct && (
                                                                                    <span className="rounded-depth-full bg-[var(--depth-color-primary)]/20 px-2 py-1 text-[10px] font-bold text-[var(--depth-color-primary)]">
                                                                                        BENAR
                                                                                    </span>
                                                                                )}

                                                                                {selected && (
                                                                                    <span className="rounded-depth-full bg-amber-400/20 px-2 py-1 text-[10px] font-bold text-amber-300">
                                                                                        DIPILIH
                                                                                    </span>
                                                                                )}
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                );
                                                            },
                                                        )}
                                                    </ul>
                                                ) : (
                                                    <div className="mt-4 rounded-depth-md border border-depth bg-depth-interactive p-4 text-sm">
                                                        {item.attachmentUrl && (
                                                            <div className="mb-4">
                                                                {isImage(
                                                                    item.attachmentUrl,
                                                                ) ? (
                                                                    <img
                                                                        src={item.attachmentUrl}
                                                                        alt="Lampiran jawaban"
                                                                        className="max-h-72 w-full rounded-depth-md object-contain"
                                                                    />
                                                                ) : (
                                                                    <a
                                                                        href={item.attachmentUrl}
                                                                        target="_blank"
                                                                        rel="noopener noreferrer"
                                                                        className="font-semibold text-[var(--depth-color-primary)] hover:underline"
                                                                    >
                                                                        Buka
                                                                        lampiran
                                                                    </a>
                                                                )}
                                                            </div>
                                                        )}

                                                        {hasAnswer ? (
                                                            <pre className="whitespace-pre-wrap break-words font-sans leading-relaxed">
                                                                {answer}
                                                            </pre>
                                                        ) : (
                                                            !item.attachmentUrl && (
                                                                <span className="italic text-depth-secondary">
                                                                    Belum ada
                                                                    jawaban
                                                                </span>
                                                            )
                                                        )}
                                                    </div>
                                                )}
                                            </article>
                                        );
                                    })}
                                </div>
                            )}
                        </div>
                    </div>

                    {/* Fixed footer */}
                    <footer className="shrink-0 border-t border-depth bg-depth-card pt-4">
                        <div className="flex justify-end">
                            <button
                                type="button"
                                disabled={isSaving}
                                onClick={handleSubmit}
                                className="rounded-depth-md bg-[var(--depth-color-primary)] px-5 py-2 text-sm font-semibold text-white shadow-depth-sm transition hover:-translate-y-0.5 hover:shadow-depth-md disabled:opacity-60"
                            >
                                {isSaving ? "Menyimpan..." : "Simpan Nilai"}
                            </button>
                        </div>
                    </footer>
                </div>
            </div>
        </ModalOverlay>
    );
}
