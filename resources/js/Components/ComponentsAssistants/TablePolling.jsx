export default function TablePolling() {
  return (
    <div className="mt-5">
      {/* Header dengan div */}
      <div className="bg-deepForestGreen rounded-lg py-2 px-2 mb-2">
        <div className="grid grid-cols-4 gap-1">
          <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
            <h1 className="font-bold text-white text-center">Rank</h1>
          </div>
          <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
            <h1 className="font-bold text-white text-center">Nama</h1>
          </div>
          <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
            <h1 className="font-bold text-white text-center">Kode</h1>
          </div>
          <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
            <h1 className="font-bold text-white text-center">Total</h1>
          </div>
        </div>
      </div>

      {/* Kontainer untuk tabel scrollable */}
      <div className="overflow-x-auto max-h-96">
        {[...Array(10)].map((_, index) => (
          <div
            key={index}
            className="grid grid-cols-4 gap-1 bg-white border border-forestGreen py-1 px-2 mb-2 rounded-lg"
          >
            <div className="flex items-center justify-center h-full py-1 px-2 ">{index + 1}</div>
            <div className="flex items-center justify-center h-full py-1 px-2">Aliza Nurfitrian M</div>
            <div className="flex items-center justify-center h-full py-1 px-2">ALL</div>
            <div className="flex items-center justify-center h-full py-1 px-2">219</div>
          </div>
        ))}
      </div>
    </div>
  );
}
