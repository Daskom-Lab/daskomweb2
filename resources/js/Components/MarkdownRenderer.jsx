import React, { useEffect, useRef, useState } from "react";
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import remarkBreaks from "remark-breaks";
import remarkMath from "remark-math";
import rehypeKatex from "rehype-katex";
import "katex/dist/katex.min.css";

import { PrismLight as SyntaxHighlighter } from "react-syntax-highlighter";
import c from "react-syntax-highlighter/dist/esm/languages/prism/c";
import { vscDarkPlus } from "react-syntax-highlighter/dist/esm/styles/prism";
import mermaid from "mermaid";

SyntaxHighlighter.registerLanguage("c", c);

const parseMediaSize = (alt = "") => {
    if (typeof alt !== "string")
        return { altText: "", width: null };

    const match = alt.match(/^(.*?)\s*\|\s*(\d+(?:\.\d+)?)\s*(px|%)?\s*$/i);

    if (!match)
        return { altText: alt, width: null };

    const altText = match[1].trim();
    const value = Number(match[2]);
    const unit = (match[3] ?? "px").toLowerCase();

    if (!Number.isFinite(value) || value <= 0)
        return { altText: alt, width: null };

    return {
        altText,
        width:
            unit === "%"
                ? `${Math.min(value, 100)}%`
                : `${Math.min(value, 2000)}px`,
    };
};


/* ============================================================
 * GitHub Alerts
 * ============================================================ */

const ALERT_PATTERN = /^\[!(NOTE|TIP|IMPORTANT|WARNING|CAUTION)\][ \t]*(?:\r?\n)?/i;

const remarkGithubAlerts = () => (tree) => {
    const walk = (node) => {
        if (!Array.isArray(node?.children)) return;

        node.children.forEach((child) => {
            if (
                child.type === "blockquote" &&
                Array.isArray(child.children) &&
                child.children.length
            ) {
                const paragraph = child.children[0];
                const first = paragraph?.children?.[0];

                if (
                    paragraph?.type === "paragraph" &&
                    first?.type === "text"
                ) {
                    const match = first.value.match(ALERT_PATTERN);

                    if (match) {
                        const type = match[1].toLowerCase();

                        first.value = first.value.replace(ALERT_PATTERN, "");

                        if (!first.value)
                            paragraph.children.shift();

                        while (paragraph.children[0]?.type === "break")
                            paragraph.children.shift();

                        if (!paragraph.children.length)
                            child.children.shift();

                        const old = child.data?.hProperties?.className;
                        const classes = Array.isArray(old)
                            ? old
                            : old
                              ? [old]
                              : [];

                        child.data = {
                            ...(child.data ?? {}),
                            hProperties: {
                                ...(child.data?.hProperties ?? {}),
                                className: [
                                    ...classes,
                                    "markdown-alert",
                                    `markdown-alert-${type}`,
                                ],
                            },
                        };
                    }
                }
            }

            walk(child);
        });
    };

    walk(tree);
};


/* ============================================================
 * Mermaid
 * ============================================================ */

function Mermaid({ chart }) {
    const ref = useRef(null);

    useEffect(() => {
        mermaid.initialize({
            startOnLoad: false,
            theme: "dark",
        });

        let cancelled = false;

        const render = async () => {
            try {
                const id = `mermaid-${Math.random()
                    .toString(36)
                    .slice(2, 11)}`;

                const { svg } = await mermaid.render(id, chart);

                if (!cancelled && ref.current)
                    ref.current.innerHTML = svg;
            } catch (error) {
                console.error("Mermaid parsing error", error);

                if (!cancelled && ref.current)
                    ref.current.innerHTML = '<div class="text-red-500 text-sm border border-red-500 p-2 rounded">Failed to render Mermaid diagram</div>';
            }
        };

        render();

        return () => {cancelled = true;};
    }, [chart]);

    return (<div ref={ref} className="my-4 flex justify-center overflow-x-auto" />);
}


/* ============================================================
 * Copy
 * ============================================================ */

function CopyButton({ value }) {
    const [copied, setCopied] = useState(false);

    const copy = async () => {
        try {
            if (navigator.clipboard?.writeText) {
                await navigator.clipboard.writeText(value);
            } else {
                const textarea = document.createElement("textarea");
                textarea.value = value;
                textarea.style.cssText = "position:fixed;opacity:0;pointer-events:none";
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand("copy");
                textarea.remove();
            }

            setCopied(true);
            setTimeout(() => setCopied(false), 1500);
        } catch (error) {
            console.error("Failed to copy code", error);
        }
    };

    return (
        <button
            type="button"
            onClick={copy}
            className="inline-flex items-center gap-1.5 rounded-depth-md border border-white/10 bg-white/5 px-2.5 py-1 text-[11px] font-semibold text-gray-300 transition hover:bg-white/10 hover:text-white"
            title="Copy code"
        >
            {copied ? (
                <>
                    <svg
                        className="h-3.5 w-3.5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        strokeWidth="2"
                    >
                        <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                    Copied
                </>
            ) : (
                <>
                    <svg
                        className="h-3.5 w-3.5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        strokeWidth="2"
                    >
                        <rect
                            x="9"
                            y="9"
                            width="11"
                            height="11"
                            rx="2"
                        />
                        <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            d="M15 9V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7a2 2 0 002 2h3"
                        />
                    </svg>
                    Copy
                </>
            )}
        </button>
    );
}


/* ============================================================
 * Code Block
 * ============================================================ */

function FencedCodeBlock({ children }) {
    const child = React.Children.only(children);
    const className = child?.props?.className ?? "";
    const language = /language-([\w-]+)/.exec(className)?.[1] ?? null;
    const code = String( child?.props?.children ?? "").replace(/\n$/, "");

    if (language === "mermaid")
        return <Mermaid chart={code} />;

    return (
        <div className="my-4 overflow-hidden rounded-depth-md border border-depth shadow-depth-md">
            <div className="flex min-h-10 items-center justify-between border-b border-white/10 bg-[#1e1e1e] px-3 py-2">
                <span className="font-mono text-[11px] font-semibold uppercase tracking-wider text-gray-400">
                    {language ?? "code"}
                </span>

                <CopyButton value={code} />
            </div>

            <div className="overflow-x-auto">
                <SyntaxHighlighter
                    style={vscDarkPlus}
                    language={language ?? undefined}
                    PreTag="div"
                    showLineNumbers={Boolean(language)}
                    startingLineNumber={1}
                    lineNumberStyle={{
                        minWidth: "3.25em",
                        paddingRight: "1em",
                        textAlign: "right",
                        userSelect: "none",
                        opacity: 0.45,
                    }}
                    customStyle={{
                        margin: 0,
                        borderRadius: 0,
                        padding: "1rem",
                        background: "#1e1e1e",
                    }}
                    codeTagProps={{
                        style: {fontFamily: "ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace"},
                    }}
                >
                    {code}
                </SyntaxHighlighter>
            </div>
        </div>
    );
}

function remarkDisableIndentedCode() {
    const data = this.data();
    data.micromarkExtensions = data.micromarkExtensions || [];
    data.micromarkExtensions.push({ disable: { null: ["codeIndented"] } });
}

/* ============================================================
 * Media
 * ============================================================ */

const VIDEO_EXTENSIONS = /\.(mp4|webm|ogg|m4v|mov)$/i;

const isVideoUrl = (src) =>
    typeof src === "string" &&
    src.trim() !== "" &&
    VIDEO_EXTENSIONS.test(src.split(/[?#]/)[0]);

function MarkdownMedia({ src, alt, title }) {
    if (!src)
        return null;

    const { altText, width } = parseMediaSize(alt);
    const style = {
        width: width ?? "100%",
        maxWidth: "100%",
    };

    if (isVideoUrl(src)) {
        return (
            <span className="flex w-full justify-center">
                <video
                    src={src}
                    title={title}
                    controls
                    preload="metadata"
                    style={style}
                    className="max-h-[70vh] rounded-depth-lg border border-depth bg-black object-contain shadow-depth-md"
                >
                    Your browser does not support video playback.
                </video>
            </span>
        );
    }

    return (
        <span className="flex w-full justify-center">
                <img
                    src={src}
                    alt={altText}
                    style={style}
                    loading="lazy"
                    className="h-auto max-h-[70vh] w-full object-contain transition"
                />
        </span>
    );
}

const isCanvaUrl = (href) => {
    if (!href)
        return false;

    try {
        const url = new URL(href);
        return (
            url.hostname === "www.canva.com" ||
            url.hostname === "canva.com"
        );
    } catch {
        return false;
    }
};

function CanvaEmbed({ href }) {
    const url = new URL(href);
    url.searchParams.set("embed", "1");

    return (
        <div className="my-5 aspect-video overflow-hidden rounded-depth-lg border border-depth">
            <iframe
                src={url.toString()}
                title="Canva Presentation"
                className="h-full w-full border-0"
                loading="lazy"
                allowFullScreen
            />
        </div>
    );
}


/* ============================================================
 * Alerts
 * ============================================================ */

const ALERT_STYLES = {
    note: {
        label: "Note",
        container: "border-blue-500/50 bg-blue-500/10",
        title: "text-blue-400",
    },
    tip: {
        label: "Tip",
        container: "border-emerald-500/50 bg-emerald-500/10",
        title: "text-emerald-400",
    },
    important: {
        label: "Important",
        container: "border-violet-500/50 bg-violet-500/10",
        title: "text-violet-400",
    },
    warning: {
        label: "Warning",
        container: "border-amber-500/50 bg-amber-500/10",
        title: "text-amber-400",
    },
    caution: {
        label: "Caution",
        container: "border-red-500/50 bg-red-500/10",
        title: "text-red-400",
    },
};

const getAlertType = (className = "") =>
    /markdown-alert-(note|tip|important|warning|caution)/.exec(className)?.[1] ?? null;


/* ============================================================
 * Renderer
 * ============================================================ */

export default function MarkdownRenderer({
    content,
    className = "",
}) {
    const value =
        typeof content === "string"
            ? content
            : String(content ?? "");

    const getTableAlignClass = (align) => {
        switch (align) {
            case "center":
                return "text-center";
            case "right":
                return "text-right";
            default:
                return "text-left";
        }
    };

    return (
        <div className={`prose prose-invert max-w-none ${className}`}>
            <ReactMarkdown
                remarkPlugins={[remarkGfm, remarkMath, remarkGithubAlerts, remarkBreaks, remarkDisableIndentedCode]}
                rehypePlugins={[rehypeKatex]}
                components={{
                    pre: ({ children }) => (
                        <FencedCodeBlock>
                            {children}
                        </FencedCodeBlock>
                    ),

                    code: ({className = "", children, ...props}) => (
                        <code className={`rounded border border-depth bg-depth-card px-1.5 py-0.5 font-mono text-sm ${className}`} {...props}>
                            {children}
                        </code>
                    ),

                    h1: ({ children }) => (
                        <h1 className="mb-4 mt-8 text-3xl font-bold tracking-tight text-depth-primary first:mt-0">
                            {children}
                        </h1>
                    ),

                    h2: ({ children }) => (
                        <h2 className="mb-3 mt-7 text-2xl font-bold tracking-tight text-depth-primary first:mt-0">
                            {children}
                        </h2>
                    ),

                    h3: ({ children }) => (
                        <h3 className="mb-2 mt-6 text-xl font-semibold text-depth-primary first:mt-0">
                            {children}
                        </h3>
                    ),

                    h4: ({ children }) => (
                        <h4 className="mb-2 mt-5 text-lg font-semibold text-depth-primary first:mt-0">
                            {children}
                        </h4>
                    ),

                    h5: ({ children }) => (
                        <h5 className="mb-2 mt-4 text-base font-semibold leading-snug text-depth-primary first:mt-0">
                            {children}
                        </h5>
                    ),

                    h6: ({ children }) => (
                        <h6 className="mb-2 mt-3 text-sm font-semibold uppercase tracking-wide text-depth-secondary first:mt-0">
                            {children}
                        </h6>
                    ),

                    blockquote: ({
                        className = "",
                        children,
                        ...props
                    }) => {
                        const type = getAlertType(className);

                        if (!type)
                            return (
                                <blockquote className="my-4 border-l-4 border-depth pl-4 text-depth-secondary bg-black/20" {...props}>
                                    {children}
                                </blockquote>
                            );

                        const alert = ALERT_STYLES[type];

                        return (
                            <div className={`my-4 border-l-4 px-4 py-3 ${alert.container}`}>
                                <div className={`mb-2 flex items-center gap-2 text-sm font-bold ${alert.title}`}>
                                    <svg
                                        className="h-4 w-4 shrink-0"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        strokeWidth="2"
                                    >
                                        <circle cx="12" cy="12" r="9"/>
                                        <path strokeLinecap="round" d="M12 11v5"/>
                                        <path strokeLinecap="round" d="M12 8h.01"/>
                                    </svg>

                                    {alert.label}
                                </div>

                                <div className="text-sm text-depth-primary [&>*:last-child]:mb-0">
                                    {children}
                                </div>
                            </div>
                        );
                    },

                    input: ({ type, checked, ...props }) => {
                        if (type !== "checkbox") {
                            return <input type={type} {...props} />;
                        }

                        return (
                            <input
                                type="checkbox"
                                checked={checked}
                                readOnly
                                disabled
                                className="
                                    mr-2 inline-grid h-4 w-4 shrink-0
                                    appearance-none place-content-center
                                    rounded border border-depth
                                    bg-depth-card
                                    align-[-2px]
                                    before:h-2 before:w-2
                                    before:scale-0 before:transform
                                    before:rounded-sm before:bg-white
                                    before:content-['']
                                    checked:border-blue-500
                                    checked:bg-blue-500
                                    checked:before:scale-100
                                    disabled:cursor-default disabled:opacity-100
                                "
                                {...props}
                            />
                        );
                    },

                    img: ({ src, alt, title }) => (
                        <MarkdownMedia
                            src={src}
                            alt={alt}
                            title={title}
                        />
                    ),

                    p: ({ children }) => (
                        <p className="mb-3 leading-7 whitespace-pre-wrap last:mb-0">
                            {children}
                        </p>
                    ),

                    ul: ({ className = "", children, ...props }) => (
                        <ul className={`mb-2 list-outside pl-5 ${className.includes("contains-task-list") ? "list-none pl-0" : "list-disc"}`} {...props}>
                            {children}
                        </ul>
                    ),

                    li: ({ className = "", children, ...props }) => (
                        <li className={`mb-1 ${className.includes("task-list-item") ? "flex items-start gap-1" : ""}`} {...props}>
                            {children}
                        </li>
                    ),

                    ol: ({ children }) => (
                        <ol className="mb-2 list-inside list-decimal">
                            {children}
                        </ol>
                    ),

                    table: ({ children }) => (
                        <div className="my-3 overflow-x-auto rounded-lg">
                            <table className="min-w-full border-collapse border border-depth text-sm">
                                {children}
                            </table>
                        </div>
                    ),

                    thead: ({ children }) => (
                        <thead className="bg-depth-interactive">
                            {children}
                        </thead>
                    ),

                    tbody: ({ children }) => (
                        <tbody className="divide-y divide-depth">
                            {children}
                        </tbody>
                    ),

                    th: ({ children, align, ...props }) => (
                        <th
                            align={align}
                            className={`whitespace-nowrap border border-depth px-2.5 py-2 text-xs font-semibold uppercase tracking-wider text-depth-secondary ${getTableAlignClass(align)}`}
                            {...props}
                        >
                            {children}
                        </th>
                    ),

                    td: ({ children, align, ...props }) => (
                        <td
                            align={align}
                            className={`border-x border-depth px-2.5 py-2 text-sm text-depth-primary ${getTableAlignClass(align)}`}
                            {...props}
                        >
                            {children}
                        </td>
                    ),

                    a: ({ children, href, ...props }) => {
                        if (isCanvaUrl(href)) {
                            return (
                                <CanvaEmbed href={href} />
                            );
                        }
                        return (
                            <a
                                href={href}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="font-medium text-blue-400 underline decoration-blue-400/40 underline-offset-2 transition-colors hover:text-blue-300 hover:decoration-blue-300"
                                {...props}
                            >
                                {children}
                            </a>
                        )
                    },


                    hr: () => (
                        <hr className="my-6 border-0 border-t border-depth"/>
                    ),
                }}
            >
                {value}
            </ReactMarkdown>
        </div>
    );
}
