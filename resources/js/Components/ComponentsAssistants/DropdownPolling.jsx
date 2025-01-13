import { useState } from "react";

export default function DropdownPolling() {
  const [isOpen, setIsOpen] = useState(false);
  const [selectedOption, setSelectedOption] = useState("-- Pilih Kategori --");

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
              onClick={() => handleSelect("Tergalak")}
              className="px-4 py-2 text-darkBrown hover:bg-gray-100 cursor-pointer"
            >
              Tergalak
            </li>
            <li
              onClick={() => handleSelect("TerPelit")}
              className="px-4 py-2 text-darkBrown hover:bg-gray-100 cursor-pointer"
            >
              TerPelit
            </li>
            <li
              onClick={() => handleSelect("Tercantik")}
              className="px-4 py-2 text-darkBrown hover:bg-gray-100 cursor-pointer"
            >
              Tercantik
            </li>
            <li
              onClick={() => handleSelect("Terwibu")}
              className="px-4 py-2 text-darkBrown hover:bg-gray-100 cursor-pointer"
            >
              Terwibu
            </li>
          </ul>
        </div>
      )}
    </div>
  );
}
