"use client";

import { useState } from "react";

export default function DropdownKelasRanking() {
  const [isOpen, setIsOpen] = useState(false);
  const [selectedOption, setSelectedOption] = useState("-- Pilih Kelas --");

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
              onClick={() => handleSelect("-- Parallel --")}
              className="px-4 py-2 text-darkBrown hover:bg-gray-100 cursor-pointer"
            >
              -- Parallel --
            </li>
            <li
              onClick={() => handleSelect("TT-46-01")}
              className="px-4 py-2 text-darkBrown hover:bg-gray-100 cursor-pointer"
            >
              TT-46-01
            </li>
            <li
              onClick={() => handleSelect("TT-46-02")}
              className="px-4 py-2 text-darkBrown hover:bg-gray-100 cursor-pointer"
            >
              TT-46-02
            </li>
            <li
              onClick={() => handleSelect("TT-46-03")}
              className="px-4 py-2 text-darkBrown hover:bg-gray-100 cursor-pointer"
            >
              TT-46-03
            </li>
            <li
              onClick={() => handleSelect("TT-46-04")}
              className="px-4 py-2 text-darkBrown hover:bg-gray-100 cursor-pointer"
            >
              TT-46-04
            </li>
          </ul>
        </div>
      )}
    </div>
  );
}
