import MarkdownRenderer from "../../MarkdownRenderer";
import { Image } from "@imagekit/react";

const parseFileAnswer = (value) => {
    if (!value) {
        return null;
    }

    // Already an object
    if (
        typeof value === "object" &&
        value?.type === "file" &&
        value?.url
    ) {
        return value;
    }

    // Stored as JSON string in database
    if (typeof value === "string") {
        try {
            const parsed = JSON.parse(value);

            if (
                parsed &&
                parsed.type === "file" &&
                parsed.url
            ) {
                return parsed;
            }
        } catch {
            // Normal text answer, so ignore JSON parsing failure
        }
    }

    return null;
};

const AnswerContent = ({ answer }) => {
    if (!answer) {
        return (
            <span className="italic text-depth-secondary">
                Tidak ada jawaban
            </span>
        );
    }

    const fileAnswer = parseFileAnswer(answer);

    // Image/file answer
    if (fileAnswer) {
        return (
            <div className="space-y-3">
                <a
                    href={fileAnswer.url}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="block w-fit max-w-full"
                >
                    <Image
                        src={fileAnswer.url}
                        alt="Jawaban Tugas Pendahuluan"
                        transformation={[
                            {
                                width: "1000",
                                quality: "85",
                            },
                        ]}
                        className="max-h-[600px] max-w-full rounded-depth-md border border-depth object-contain shadow-depth-sm transition hover:opacity-90"
                        loading="lazy"
                    />
                </a>

                <div className="flex items-center gap-2">
                    <a
                        href={fileAnswer.url}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="inline-flex items-center gap-1.5 rounded-depth-md border border-depth bg-depth-card px-3 py-1.5 text-xs font-semibold text-depth-primary shadow-depth-sm transition hover:border-[var(--depth-color-primary)] hover:text-[var(--depth-color-primary)]"
                    >
                        <svg
                            className="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            strokeWidth={2}
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="M14 3h7v7m0-7L10 14"
                            />
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="M21 14v5a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h5"
                            />
                        </svg>

                        Buka gambar penuh
                    </a>
                </div>
            </div>
        );
    }

    // Normal text answer
    return (
        <pre className="whitespace-pre-wrap break-words text-md font-sans leading-relaxed">
            {answer}
        </pre>
    )
};

export default function ContentLihatTP({
    jawabanData,
    praktikan,
    modul,
}) {
    const hasData =
        Array.isArray(jawabanData) &&
        jawabanData.length > 0;

    return (
        <div className="space-y-5">
            {/* ── Info card ── */}
            {praktikan && modul && (
                <div className="rounded-depth-lg border border-depth bg-depth-card shadow-depth-md">
                    <div className="border-b border-depth px-5 py-3">
                        <h2 className="text-xs font-semibold uppercase tracking-widest text-depth-secondary">
                            Informasi Praktikan
                        </h2>
                    </div>

                    <div className="grid grid-cols-1 gap-x-8 gap-y-3 px-5 py-4 sm:grid-cols-3">
                        <div className="flex flex-col gap-0.5">
                            <span className="text-[10px] font-semibold uppercase tracking-wider text-depth-secondary">
                                Nama
                            </span>

                            <span className="text-sm font-medium text-depth-primary">
                                {praktikan.nama}
                            </span>
                        </div>

                        <div className="flex flex-col gap-0.5">
                            <span className="text-[10px] font-semibold uppercase tracking-wider text-depth-secondary">
                                NIM
                            </span>

                            <span className="text-sm font-mono font-medium text-depth-primary">
                                {praktikan.nim}
                            </span>
                        </div>

                        <div className="flex flex-col gap-0.5">
                            <span className="text-[10px] font-semibold uppercase tracking-wider text-depth-secondary">
                                Modul
                            </span>

                            <span className="text-sm font-medium text-depth-primary">
                                {modul.judul}
                            </span>
                        </div>
                    </div>
                </div>
            )}

            {/* ── Q&A list ── */}
            <div className="rounded-depth-lg border border-depth bg-depth-card shadow-depth-md">
                <div className="border-b border-depth px-5 py-3">
                    <h2 className="text-xs font-semibold uppercase tracking-widest text-depth-secondary">
                        Jawaban Tugas Pendahuluan

                        {hasData && (
                            <span className="ml-2 inline-flex items-center rounded-depth-full border border-depth bg-depth-interactive px-2 py-0.5 text-[10px] font-semibold normal-case tracking-normal text-depth-primary">
                                {jawabanData.length} soal
                            </span>
                        )}
                    </h2>
                </div>

                <div className="divide-y divide-[color:var(--depth-border)]">
                    {hasData ? (
                        jawabanData.map((item, index) => (
                            <div
                                key={item.soal_id}
                                className="px-5 py-5"
                            >
                                {/* Question */}
                                <div className="mb-3 flex gap-3">
                                    <span className="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-depth-md bg-[var(--depth-color-primary)] text-xs font-bold text-white shadow-depth-sm">
                                        {index + 1}
                                    </span>

                                    <div className="min-w-0 flex-1 text-sm font-semibold leading-relaxed text-depth-primary">
                                        <MarkdownRenderer
                                            content={item.soal_text}
                                        />
                                    </div>
                                </div>

                                {/* Answer */}
                                <div
                                    className="ml-9 rounded-depth-md border border-depth bg-depth-interactive px-4 py-3"
                                    style={{
                                        borderLeftWidth: "3px",
                                        borderLeftColor:
                                            "var(--depth-color-primary)",
                                    }}
                                >
                                    <div className="mb-1.5 flex items-center gap-1.5">
                                        <svg
                                            className="h-3.5 w-3.5 shrink-0 text-[var(--depth-color-primary)]"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            strokeWidth={2}
                                        >
                                            <path
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                d="M8 10h8M8 14h5"
                                            />

                                            <rect
                                                x="3"
                                                y="4"
                                                width="18"
                                                height="16"
                                                rx="2"
                                            />
                                        </svg>

                                        <span className="text-[10px] font-semibold uppercase tracking-wider text-[var(--depth-color-primary)]">
                                            Jawaban
                                        </span>
                                    </div>

                                    <div className="min-w-0 overflow-x-auto text-sm leading-relaxed text-depth-primary">
                                        <AnswerContent
                                            answer={item.jawaban}
                                        />
                                    </div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <div className="flex flex-col items-center justify-center gap-2 py-14 text-center text-depth-secondary">
                            <svg
                                className="h-10 w-10 opacity-40"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                strokeWidth={1.5}
                            >
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                />

                                <path
                                    strokeLinecap="round"
                                    d="M9 9h.01M15 9h.01M9.5 14.5s.8 1.5 2.5 1.5 2.5-1.5 2.5-1.5"
                                />
                            </svg>

                            <p className="text-sm">
                                Belum ada jawaban yang
                                tersubmit untuk modul ini.
                            </p>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}
