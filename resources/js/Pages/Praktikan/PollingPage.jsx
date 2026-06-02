import { Head } from "@inertiajs/react";
import { useState, useEffect, useCallback } from "react";
import { useQuery } from "@tanstack/react-query";
import { api } from "@/lib/api";
import { send } from "@/lib/http";
import { store as storePollings } from "@/lib/routes/pollings";
import PraktikanAuthenticated from "@/Layouts/PraktikanAuthenticatedLayout";
import PollingHeader from "@/Components/Praktikans/Sections/PollingHeader";
import PollingContent from "@/Components/Praktikans/Sections/PollingContent";
import PraktikanPageHeader from "@/Components/Praktikans/Common/PraktikanPageHeader";
import PraktikanUtilities from "@/Components/Praktikans/Layout/PraktikanUtilities";

// Typewriter Component
function TypewriterText({ text, onComplete, speed = 50 }) {
    const [displayedText, setDisplayedText] = useState("");
    const [currentIndex, setCurrentIndex] = useState(0);
    const [isComplete, setIsComplete] = useState(false);

    useEffect(() => {
        if (currentIndex < text.length) {
            const timeout = setTimeout(() => {
                setDisplayedText(prev => prev + text[currentIndex]);
                setCurrentIndex(prev => prev + 1);
            }, speed);
            return () => clearTimeout(timeout);
        } else if (!isComplete) {
            setIsComplete(true);
            if (onComplete) {
                setTimeout(onComplete, 1000);
            }
        }
    }, [currentIndex, text, speed, onComplete, isComplete]);

    return (
        <span>
            {displayedText}
            {currentIndex < text.length && (
                <span className="animate-pulse">|</span>
            )}
        </span>
    );
}

// Intro Scene Component
function IntroScene({ onComplete }) {
    const [phase, setPhase] = useState(0);
    const [showSkip, setShowSkip] = useState(false);

    const introTexts = [
        "Akhirnya praktikum satu semester kelar juga! 🎉",
        "Makasih buat semua effort dan partisipasi kalian selama ini.",
        "",
        "Sebelum benar-benar selesai, saatnya kita tentukan siapa yang pantas naik tahta sebagai pemegang title selanjutnya 👑"
    ];

    useEffect(() => {
        const timer = setTimeout(() => setShowSkip(true), 2000);
        return () => clearTimeout(timer);
    }, []);

    const handlePhaseComplete = useCallback(() => {
        if (phase < introTexts.length - 1) {
            setPhase(prev => prev + 1);
        } else {
            setTimeout(onComplete, 1500);
        }
    }, [phase, introTexts.length, onComplete]);

    return (
        <div className="fixed inset-0 z-[100] flex items-center justify-center bg-gradient-to-br from-gray-900 via-slate-900 to-gray-900">
            {/* Animated background particles */}
            <div className="absolute inset-0 overflow-hidden">
                {[...Array(20)].map((_, i) => (
                    <div
                        key={i}
                        className="absolute rounded-full bg-[var(--depth-color-primary)] opacity-10"
                        style={{
                            width: `${Math.random() * 10 + 5}px`,
                            height: `${Math.random() * 10 + 5}px`,
                            left: `${Math.random() * 100}%`,
                            top: `${Math.random() * 100}%`,
                            animation: `float ${Math.random() * 10 + 10}s linear infinite`,
                            animationDelay: `${Math.random() * 5}s`
                        }}
                    />
                ))}
            </div>

            {/* Content */}
            <div className="relative z-10 max-w-3xl px-8 text-center">
                <div className="mb-8 text-4xl font-bold leading-relaxed text-white md:text-5xl">
                    {introTexts.slice(0, phase + 1).map((text, idx) => (
                        <p key={idx} className={`mb-4 ${idx === phase ? '' : 'opacity-60'}`}>
                            {idx === phase ? (
                                <TypewriterText
                                    text={text}
                                    onComplete={handlePhaseComplete}
                                    speed={40}
                                />
                            ) : (
                                text
                            )}
                        </p>
                    ))}
                </div>

                {/* Progress indicator */}
                <div className="mt-8 flex justify-center gap-2">
                    {introTexts.map((_, idx) => (
                        <div
                            key={idx}
                            className={`h-2 w-2 rounded-full transition-all duration-500 ${idx <= phase
                                ? 'bg-[var(--depth-color-primary)] scale-125'
                                : 'bg-gray-600'
                                }`}
                        />
                    ))}
                </div>
            </div>

            {/* Skip button */}
            {showSkip && (
                <button
                    onClick={onComplete}
                    className="absolute bottom-8 right-8 rounded-full border border-white/20 bg-white/10 px-6 py-2 text-sm font-medium text-white/80 backdrop-blur-sm transition-all hover:bg-white/20 hover:text-white"
                >
                    Skip →
                </button>
            )}

            {/* CSS for floating animation */}
            <style>{`
                @keyframes float {
                    0%, 100% {
                        transform: translateY(0) translateX(0);
                        opacity: 0.1;
                    }
                    25% {
                        transform: translateY(-100px) translateX(50px);
                        opacity: 0.2;
                    }
                    50% {
                        transform: translateY(-200px) translateX(-25px);
                        opacity: 0.15;
                    }
                    75% {
                        transform: translateY(-100px) translateX(-50px);
                        opacity: 0.2;
                    }
                }
            `}</style>
        </div>
    );
}

// Fullscreen Polling Session Component
function FullscreenPollingSession({
    activeCategory,
    setActiveCategory,
    availableCategories,
    asistens,
    loading,
    error,
    selectedCards,
    setSelectedCards,
    isSubmitted,
    submitError,
    handleSubmit
}) {
    return (
        <div className="fixed inset-0 z-[90] flex flex-col overflow-hidden">
            {/* Blurred dark background */}
            <div className="absolute inset-0 bg-gradient-to-br from-gray-900/95 via-slate-900/95 to-gray-900/95 backdrop-blur-xl" />

            {/* Content */}
            <div className="relative z-10 flex h-full flex-col p-6">
                {/* Header */}
                <div className="mb-6 text-center">
                    <h1 className="text-3xl font-bold text-white md:text-4xl">
                        Polling Asisten Terbaik
                    </h1>
                    <p className="mt-2 text-lg text-gray-300">
                        Pilih asisten favorit kamu untuk setiap kategori
                    </p>
                </div>

                {/* Category tabs */}
                <div className="mb-6 grid grid-cols-[1fr_auto] items-center gap-4 w-full">

                    {/* 1. Category Scroll Area */}
                    <div className="min-w-0"> {/* min-w-0 is mandatory for the scroll to trigger */}
                        <div className="flex overflow-x-auto gap-3 pb-2 no-scrollbar">
                            {availableCategories.map((category) => (
                                <button
                                    key={category.id}
                                    onClick={() => setActiveCategory(category.id.toString())}
                                    className={`whitespace-nowrap flex-none rounded-full px-6 py-2 text-sm font-semibold transition-all ${activeCategory === category.id.toString()
                                        ? 'bg-[var(--depth-color-primary)] text-white shadow-lg shadow-[var(--depth-color-primary)]/30'
                                        : 'bg-white/10 text-white/80 hover:bg-white/20'
                                        }`}
                                >
                                    {category.judul}
                                    {selectedCards[category.id.toString()] && (
                                        <span className="ml-2 text-green-400">✓</span>
                                    )}
                                </button>
                            ))}
                        </div>
                    </div>

                    {/* 2. Submit Button */}
                    <div className="flex-shrink-0">
                        <button
                            type="button"
                            onClick={handleSubmit}
                            className={`inline-flex items-center gap-2 rounded-full px-8 py-3 text-base font-bold shadow-xl transition-all ${isSubmitted
                                ? "cursor-not-allowed bg-gray-600 text-gray-400"
                                : "bg-gradient-to-r from-[var(--depth-color-primary)] to-purple-600 text-white hover:scale-105 hover:shadow-2xl hover:shadow-[var(--depth-color-primary)]/40"
                                }`}
                            disabled={isSubmitted}
                        >
                            <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                            </svg>
                            <span className="whitespace-nowrap">Submit Polling</span>
                        </button>
                    </div>
                </div>

                {submitError && (
                    <div className="mx-auto mb-4 max-w-md rounded-lg border border-red-500/30 bg-red-500/10 p-3 text-center">
                        <p className="text-sm text-red-400">{submitError}</p>
                    </div>
                )}

                {/* Polling content - scrollable area */}
                <div className="flex-1 overflow-hidden rounded-2xl border border-white/10 bg-white/5 backdrop-blur-sm">
                    <PollingContent
                        activeCategory={activeCategory}
                        asistens={asistens}
                        loading={loading}
                        error={error}
                        selectedCards={selectedCards}
                        setSelectedCards={setSelectedCards}
                        isSubmitted={isSubmitted}
                        fullscreenMode={true}
                    />
                </div>
            </div>
        </div>
    );
}

export default function PollingPage({ auth }) {
    const user = auth?.praktikan;

    const [showIntro, setShowIntro] = useState(() => {
        if (!user?.id) return true;
        const hasSeenIntro = sessionStorage.getItem(`pollingIntroSeen_${user.id}`);
        return !hasSeenIntro;
    });
    const [showPollingSession, setShowPollingSession] = useState(false);

    const [activeCategory, setActiveCategory] = useState(null);
    const [selectedCards, setSelectedCards] = useState(() => {
        const storedCards = localStorage.getItem("selectedCards");
        return storedCards ? JSON.parse(storedCards) : {};
    });
    const [isSubmitted, setIsSubmitted] = useState(false);
    const [showModal, setShowModal] = useState(false);
    const [submitError, setSubmitError] = useState(null);

    // Moved from PollingContent
    const [asistens, setAsistens] = useState([]);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    // New states for tracking categories
    const [categories, setCategories] = useState([]);
    const [submittedCategories, setSubmittedCategories] = useState([]);
    const [availableCategories, setAvailableCategories] = useState([]);
    const [allCategoriesSubmitted, setAllCategoriesSubmitted] = useState(false);
    const [isPollingActive, setIsPollingActive] = useState(null);

    const getPollingId = (categoryId) => {
        return categoryId;
    };

    // Handle intro completion
    const handleIntroComplete = useCallback(() => {
        if (user?.id) {
            sessionStorage.setItem(`pollingIntroSeen_${user.id}`, "true");
        }
        setShowIntro(false);
        setShowPollingSession(true);
    }, [user]);

    // Fetch categories to know total count
    const categoriesQuery = useQuery({
        queryKey: ['jenis-polling'],
        queryFn: async () => {
            const { data } = await api.get('/api-v1/jenis-polling');
            return data ?? {};
        },
    });

    useEffect(() => {
        if (categoriesQuery.data) {
            const fetched = Array.isArray(categoriesQuery.data?.categories)
                ? categoriesQuery.data.categories
                : Array.isArray(categoriesQuery.data)
                    ? categoriesQuery.data
                    : [];
            setCategories(fetched);
            if (typeof categoriesQuery.data?.polling_active !== "undefined") {
                setIsPollingActive(Boolean(categoriesQuery.data.polling_active));
            }
            if (Array.isArray(categoriesQuery.data?.submitted_categories)) {
                setSubmittedCategories(categoriesQuery.data.submitted_categories);
            }
        }
    }, [categoriesQuery.data]);

    useEffect(() => {
        if (!isPollingActive) {
            setActiveCategory(null);
            setAvailableCategories([]);
        }
    }, [isPollingActive]);

    // Filter available categories (exclude submitted ones)
    useEffect(() => {
        if (categories.length > 0) {
            const available = categories.filter(category =>
                !submittedCategories.includes(category.id.toString())
            );
            setAvailableCategories(available);

            // Set first available category as active if none selected
            if (!activeCategory && available.length > 0) {
                setActiveCategory(available[0].id.toString());
            }

            // Check if all categories are submitted
            if (available.length === 0 && categories.length > 0) {
                setAllCategoriesSubmitted(true);
            }
        }
    }, [categories, submittedCategories, activeCategory]);

    // If polling is active and has categories, show fullscreen session
    useEffect(() => {
        if (!showIntro && isPollingActive && availableCategories.length > 0) {
            setShowPollingSession(true);
        }
    }, [showIntro, isPollingActive, availableCategories]);

    const asistenQuery = useQuery({
        queryKey: ['asisten', activeCategory],
        enabled: Boolean(activeCategory) && isPollingActive,
        queryFn: async () => {
            const { data } = await api.get('/api-v1/asisten');
            if (data?.success) {
                // Filter out BOT assistants
                const filteredAsisten = (data.asisten ?? []).filter(
                    asisten => asisten.kode !== 'BOT'
                );
                return filteredAsisten;
            }
            throw new Error(data?.message ?? 'Failed to fetch asisten');
        },
    });

    useEffect(() => {
        if (asistenQuery.isSuccess && asistenQuery.data) {
            setAsistens(asistenQuery.data);
            setError(null);
        }
        if (asistenQuery.isError) {
            setError(asistenQuery.error?.message ?? 'Failed to fetch asisten');
        }
        setLoading(asistenQuery.isLoading);
    }, [asistenQuery.isLoading, asistenQuery.isSuccess, asistenQuery.isError, asistenQuery.data, asistenQuery.error]);

    const handleSubmitAll = async () => {
        if (!user || !selectedCards) {
            console.error("User or selectedCards missing", { user, selectedCards });
            return { success: false, message: 'User information or selections are missing' };
        }

        try {
            const submissions = Object.entries(selectedCards)
                .filter(([categoryId, asisten]) => categoryId && asisten && asisten.kode)
                .map(([categoryId, asisten]) => ({
                    polling_id: getPollingId(categoryId),
                    kode: asisten.kode,
                    praktikan_id: user.id
                }));

            if (submissions.length === 0) {
                return { success: false, message: 'Pilih minimal 1 asisten sebelum mengirim' };
            }

            const { data } = await send(storePollings(), submissions);

            if (data?.status === 'success') {
                const newSubmittedCategories = [...new Set([...submittedCategories, ...submissions.map(s => s.polling_id.toString())])];
                setSubmittedCategories(newSubmittedCategories);
                
                // Clear any old local storage data that might conflict
                localStorage.removeItem("submittedCategories");

                setSelectedCards({});
                localStorage.removeItem("selectedCards");
                localStorage.removeItem("activeModalCards");

                setActiveCategory(null);

                return { success: true, message: 'Polling submitted successfully!' };
            }

            throw new Error(data?.message ?? 'Server returned non-success status');
        } catch (err) {
            console.error('Submission error:', err);
            return { success: false, message: 'Failed to submit pollings: ' + (err.message || 'Unknown error') };
        }
    };

    const handleSubmit = async () => {
        if (isSubmitted) return;

        try {
            const result = await handleSubmitAll();

            if (result.success) {
                setIsSubmitted(true);
                setSubmitError(null);
                setShowModal(true);
                localStorage.setItem("submittedCards", JSON.stringify(selectedCards));

                setTimeout(() => {
                    setShowModal(false);
                    setIsSubmitted(false); // Reset for next category
                    setShowPollingSession(false); // Exit fullscreen mode
                }, 2000);
            } else {
                setSubmitError(result.message);
            }
        } catch (error) {
            console.error("Error submitting:", error);
            setSubmitError("An unexpected error occurred");
        }
    };

    const renderPlaceholder = (titleText, subtitleText) => (
        <div className="p-8 mb-10">
            <div className="flex min-h-[70vh] flex-col items-center justify-center gap-3">
                <h1 className="text-3xl font-bold text-[var(--depth-color-primary)]">{titleText}</h1>
                {subtitleText ? (
                    <p className="text-lg text-depth-secondary">{subtitleText}</p>
                ) : null}
            </div>
        </div>
    );

    const showInactivePlaceholder = isPollingActive === false;
    const showCompletedPlaceholder = !showInactivePlaceholder && allCategoriesSubmitted;

    return (
        <>
            <PraktikanAuthenticated
                user={auth?.user ?? auth?.praktikan ?? null}
                praktikan={auth?.praktikan ?? auth?.user ?? null}
                customWidth="w-[80%]"
                header={
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Dashboard
                    </h2>
                }
            >
                <Head title="Polling Praktikan" />

                <div className="mt-[8vh] flex flex-col gap-6">
                    <PraktikanPageHeader title="Polling Asisten" />

                    {isPollingActive === null ? (
                        <div className="p-8 mb-10">
                            <div className="flex min-h-[70vh] flex-col items-center justify-center gap-3">
                                <div className="w-10 h-10 border-4 border-[var(--depth-color-primary)] border-t-transparent rounded-full animate-spin"></div>
                                <p className="text-depth-secondary">Memuat polling...</p>
                            </div>
                        </div>
                    ) : showInactivePlaceholder ? (
                        renderPlaceholder(
                            "Polling sedang tidak aktif",
                            "Silakan kembali lagi nanti ketika polling telah dibuka."
                        )
                    ) : showCompletedPlaceholder ? (
                        renderPlaceholder(
                            "Terima kasih sudah mengikuti polling",
                            "Semua kategori polling telah berhasil dikirim."
                        )
                    ) : (
                        <>
                            <div className="flex items-center justify-end">
                                <button
                                    type="button"
                                    onClick={() => setShowPollingSession(true)}
                                    className="inline-flex items-center gap-2 rounded-depth-md border border-[var(--depth-color-primary)] bg-[var(--depth-color-primary)] px-6 py-3 text-sm font-semibold text-white shadow-depth-md transition-all hover:-translate-y-0.5 hover:shadow-depth-lg"
                                >
                                    <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Mulai Polling
                                </button>
                            </div>
                        </>
                    )}
                </div>
            </PraktikanAuthenticated>
            <PraktikanUtilities />

            {/* Intro Scene */}
            {showIntro && isPollingActive && !showCompletedPlaceholder && (
                <IntroScene onComplete={handleIntroComplete} />
            )}

            {/* Fullscreen Polling Session */}
            {showPollingSession && !showIntro && isPollingActive && !showCompletedPlaceholder && (
                <FullscreenPollingSession
                    activeCategory={activeCategory}
                    setActiveCategory={setActiveCategory}
                    availableCategories={availableCategories}
                    asistens={asistens}
                    loading={loading}
                    error={error}
                    selectedCards={selectedCards}
                    setSelectedCards={setSelectedCards}
                    isSubmitted={isSubmitted}
                    submitError={submitError}
                    handleSubmit={handleSubmit}
                />
            )}

            {/* Success Modal */}
            {showModal && (
                <div className="fixed inset-0 z-[110] flex items-center justify-center bg-black/60 backdrop-blur-sm">
                    <div className="animate-bounce rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 p-8 text-center text-white shadow-2xl">
                        <div className="mb-4 text-6xl">🎉</div>
                        <h2 className="text-2xl font-bold">Berhasil!</h2>
                        <p className="mt-2 text-green-100">Polling berhasil dikirim</p>
                    </div>
                </div>
            )}
        </>
    );
}
