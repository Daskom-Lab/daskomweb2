export default function CloseButton({ closePopup, className = "", ...props }) {
    return (
        <button
            {...props}
            onClick={closePopup}
            className={
                "bg-rustyRed text-white font-bold p-0.5 m-1 rounded-md shadow-lg hover:bg-red-900 focus:outline-none focus:ring-opacity-50 " +
                className
            }
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                className="h-5 w-7"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                strokeWidth={2}
            >
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>
        </button>
    );
}
