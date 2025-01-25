export default function ModalCard({ card }) {
    return (
        <div className="absolute inset-0 flex items-center justify-center z-50 pointer-events-none">
            <div className="bg-white rounded-lg shadow-xl p-6 w-96 text-center">
                <img
                    src={card.image}
                    alt={card.name}
                    className="rounded-full w-32 h-auto mx-auto mb-4"
                />
                <h3 className="font-bold text-xl text-gray-800">{card.name}</h3>
                <p className="font-semibold text-gray-600">{card.description}</p>
            </div>
        </div>
    );
}