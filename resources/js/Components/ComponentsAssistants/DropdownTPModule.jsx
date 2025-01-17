export default function DropdownTPModule({ program }) {
    // Modul berdasarkan klas
    const regulerModul = ["Modul 1", "Modul 2", "Modul 3"];
    const interModul = ["Modul A", "Modul B", "Modul C"];
  
    // Tentukan modul 
    const modulOptions = program === "Internasional" ? interModul : regulerModul;
  
    return (
      <div className="flex flex-col items-start w-80">
        <label htmlFor="modul" className="text-gray-600 font-medium mb-1">
          Pilih Modul
        </label>
        <select
          id="modul"
          className="w-full px-4 py-2 text-gray-600 bg-gray-200 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-deepForestGreen"
        >
          {modulOptions.map((modul, index) => (
            <option key={index} value={modul}>
              {modul}
            </option>
          ))}
        </select>
      </div>
    );
  }
  