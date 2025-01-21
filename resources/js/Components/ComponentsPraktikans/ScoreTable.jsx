import React from "react";

export default function ScoreTable() {
    const rows = [
        { tanggal: "99/12/2025", modul: "Modul 1", nilai: "95/100/95/95/95/95/100/95", asisten: "FYN" },
        { tanggal: "dd/mm/yyyy", modul: "Modul 2", nilai: "100/100/100/100/100/100/100/100", asisten: "FYN" },
        { tanggal: "dd/mm/yyyy", modul: "Modul 3", nilai: "tp/ta/d1/d2/d3/d4/l1/l2", asisten: "FYN" },
        { tanggal: "dd/mm/yyyy", modul: "Modul 1", nilai: "tp/ta/d1/d2/d3/d4/l1/l2", asisten: "FYN" },
        { tanggal: "dd/mm/yyyy", modul: "Modul 2", nilai: "tp/ta/d1/d2/d3/d4/l1/l2", asisten: "FYN" },
        { tanggal: "dd/mm/yyyy", modul: "Modul 3", nilai: "tp/ta/d1/d2/d3/d4/l1/l2", asisten: "DEY" },
        { tanggal: "dd/mm/yyyy", modul: "Modul 1", nilai: "tp/ta/d1/d2/d3/d4/l1/l2", asisten: "DEY" },
        { tanggal: "dd/mm/yyyy", modul: "Modul 2", nilai: "tp/ta/d1/d2/d3/d4/l1/l2", asisten: "DEY" },
        { tanggal: "dd/mm/yyyy", modul: "Modul 3", nilai: "tp/ta/d1/d2/d3/d4/l1/l2", asisten: "DEY" },
        { tanggal: "dd/mm/yyyy", modul: "Modul 3", nilai: "tp/ta/d1/d2/d3/d4/l1/l2", asisten: "DEY" },
        { tanggal: "dd/mm/yyyy", modul: "Modul 3", nilai: "tp/ta/d1/d2/d3/d4/l1/l2", asisten: "DEY" },
        { tanggal: "dd/mm/yyyy", modul: "Modul 3", nilai: "tp/ta/d1/d2/d3/d4/l1/l2", asisten: "DEY" },
        { tanggal: "dd/mm/yyyy", modul: "Modul 3", nilai: "tp/ta/d1/d2/d3/d4/l1/l2", asisten: "DEY" },
        { tanggal: "dd/mm/yyyy", modul: "Modul 3", nilai: "tp/ta/d1/d2/d3/d4/l1/l2", asisten: "DEY" },
        { tanggal: "dd/mm/yyyy", modul: "Modul 3", nilai: "tp/ta/d1/d2/d3/d4/l1/l2", asisten: "DEY" },
        { tanggal: "dd/mm/yyyy", modul: "Modul 3", nilai: "tp/ta/d1/d2/d3/d4/l1/l2", asisten: "DEY" },
        { tanggal: "dd/mm/yyyy", modul: "Modul 4", nilai: "tp/ta/d1/d2/d3/d4/l1/l2", asisten: "DEY" }
    ];

    const Table = ({ rows }) => (
        <div className="mt-[3vh] h-[68vh] overflow-y-auto">
            <table className="min-w-full border-collapse border-2 border-black">
                <tbody>
                    {rows.map((row, index) => (
                        <tr key={index}>
                            <td className="border-2 border-black px-2 py-2 text-center w-[20%]">{row.tanggal}</td>
                            <td className="border-2 border-black px-2 py-2 text-center w-[20%]">{row.modul}</td>
                            <td className="border-2 border-black px-2 py-2 text-center w-[40%]">{row.nilai}</td>
                            <td className="border-2 border-black px-2 py-2 text-center w-[20%]">{row.asisten}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );

    return (
        <div className="mt-[-25px] bg-white rounded-lg py-4 px-4 max-w-3xl mx-auto">
            <div className="bg-deepForestGreen rounded-lg py-2 px-2">
                <div className="flex items-center gap-5">
                    <div className="ml-2 min-w-[100px] max-w-[110px] bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 w-[25%]">
                        <h1 className="mx-auto font-bold text-white  text-center">Tanggal</h1>
                    </div>
                    <div className="ml-[13px] min-w-[100px] max-w-[110px] bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 w-[25%]">
                        <h1 className="mx-auto font-bold text-white  text-center">Modul</h1>
                    </div>
                    <div className="ml-[33px] bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 w-[30%]">
                        <h1 className="mx-auto font-bold text-white  text-center">Nilai</h1>
                    </div>
                    <div className="ml-[30px] min-w-[110px] max-w-[120px] bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 w-[20%]">
                        <h1 className="mx-auto font-bold text-white  text-center">Asisten</h1>
                    </div>
                </div>
            </div>
            <Table rows={rows} />
        </div>
    );
}