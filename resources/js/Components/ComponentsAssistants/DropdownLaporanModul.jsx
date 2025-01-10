"use client";

import { useState } from "react";

export default function DropdownLaporanModul() {
  const [isOpen, setIsOpen] = useState(false);
  const [selectedOption, setSelectedOption] = useState("-- Pilih Laporan Modul --");

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
              className="px-7 py-2 text-darkBrown hover:bg-gray-100 cursor-pointer"
            >
              Modul 1
            </li>
            <li
              onClick={() => handleSelect("Modul 2")}
              className="px-7 py-2 text-darkBrown hover:bg-gray-100 cursor-pointer"
            >
              Modul 2
            </li>
            <li
              onClick={() => handleSelect("Modul 3")}
              className="px-7 py-2 text-darkBrown hover:bg-gray-100 cursor-pointer"
            >
              Modul 3
            </li>
            <li
              onClick={() => handleSelect("Modul 4")}
              className="px-7 py-2 text-darkBrown hover:bg-gray-100 cursor-pointer"
            >
              Modul 4
            </li>
          </ul>
        </div>
      )}
    </div>
  );
}
