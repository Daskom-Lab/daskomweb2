import { useState } from "react";

export default function DropdownListModul() {
  const [isOpen, setIsOpen] = useState(false);
  const [selectedOption, setSelectedOption] = useState("-- Pilih Modul --");

  const toggleDropdown = () => {
    setIsOpen(!isOpen);
  };

  const handleSelect = (option) => {
    setSelectedOption(option);
    setIsOpen(false);
  };

  return (
    <div className="relative">
      <button
        onClick={toggleDropdown}
        className="flex items-center gap-2 border-2 border-darkBrown text-darkBrown font-semibold rounded-md px-7 py-1 shadow-md"
      >
        {selectedOption}
      </button>
      {isOpen && (
        <div className="absolute right-0 mt-2 bg-white border-2 border-darkBrown rounded-md shadow-md w-[168px]">
          <ul>
            <li
              onClick={() => handleSelect("Modul 1")}
              className="px-4 py-2 text-darkBrown hover:bg-gray-100 cursor-pointer"
            >
              Modul 1
            </li>
            <li
              onClick={() => handleSelect("Modul 1 (Eng)")}
              className="px-4 py-2 text-darkBrown hover:bg-gray-100 cursor-pointer"
            >
              Modul 1 (Eng)
            </li>
            <li
              onClick={() => handleSelect("Modul 2")}
              className="px-4 py-2 text-darkBrown hover:bg-gray-100 cursor-pointer"
            >
              Modul 2
            </li>
            <li
              onClick={() => handleSelect("Modul 2 (Eng)")}
              className="px-4 py-2 text-darkBrown hover:bg-gray-100 cursor-pointer"
            >
              Modul 2 (Eng)
            </li>
          </ul>
        </div>
      )}
    </div>
  );
}
