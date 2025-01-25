export default function ModalReview({ taskKey, onReviewNavigate }) {
    const handleReviewClick = () => {
        if (onReviewNavigate && taskKey) {
            onReviewNavigate(taskKey);
        }
    };     

    return (
        <div className="flex flex-col items-center justify-center">
            <h1 className="mt-10 text-sm font-semibold">Open on Wednesday, 26 June 2024, 18.00 PM</h1>
            <h1 className="mt-2 mb-4 text-sm font-semibold">Open on Saturday, 29 June 2024, 18.00 PM</h1>
            <button
                className="w-[200px] mt-5 p-1 bg-white border-2 border-darkGray text-lg text-darkGray font-bold rounded-sm mb-3 hover:bg-softPearl duration-300"
                onClick={handleReviewClick}
            >
                Review
            </button>
        </div>
    );
}