import React from "react";

export default function LeaderboardTable() {
    const rows = [
        { nama: "Fauzan, Muhammad Zaidan", nim: "1104xxxxxxxxxx", kelas: "TF-46-INT", nilai: "[ 999 ]" },
        { nama: "Fauzan, Muhammad Zaidan Daskom Lab FYN", nim: "1104xxxxxxxxxx", kelas: "TF-46-03", nilai: "[ 999 ]" },
        { nama: "Muh Zaidan Fauzan", nim: "1104xxxxxxxxxx", kelas: "TF-46-03", nilai: "[ 999 ]" },
        { nama: "Muh Zaidan Fauzan", nim: "1104xxxxxxxxxx", kelas: "TF-46-03", nilai: "[ 999 ]" },
        { nama: "Muh Zaidan Fauzan", nim: "1104xxxxxxxxxx", kelas: "TF-46-03", nilai: "[ 999 ]" },
        { nama: "Muh Zaidan Fauzan", nim: "1104xxxxxxxxxx", kelas: "TF-46-03", nilai: "[ 999 ]" },
        { nama: "Muh Zaidan Fauzan", nim: "1104xxxxxxxxxx", kelas: "TF-46-03", nilai: "[ 999 ]" },
        { nama: "Muh Zaidan Fauzan", nim: "1104xxxxxxxxxx", kelas: "TF-46-03", nilai: "[ 999 ]" },
        { nama: "Muh Zaidan Fauzan", nim: "1104xxxxxxxxxx", kelas: "TF-46-03", nilai: "[ 999 ]" },
        { nama: "Muh Zaidan Fauzan", nim: "1104xxxxxxxxxx", kelas: "TF-46-03", nilai: "[ 999 ]" }
    ];

    const RowComponent = ({ nama, nim, kelas, nilai, index }) => {
        let borderColor;
        if (index === 0) borderColor = "bg-goldenAmber border-black"; 
        else if (index === 1) borderColor = "bg-gray-400 border-black"; 
        else if (index === 2) borderColor = "bg-amber-700 border-black"; 
        else borderColor = "border-black"; 

        return (
            <div className="border-b border-transparent mb-1">
                <div className="border-2 border-black flex items-center justify-between px-2 py-1 shadow-sm shadow-black">
                    <span
                        className={`ml-[22px] flex-none w-[40px] h-[40px] border-2 ${borderColor} rounded-md shadow-md flex items-center justify-center text-center font-bold`}
                    >
                        {index + 1}
                    </span>
                    <span className="flex-1 ml-[24px] pl-[1px] min-w-[145px] max-w-[146px] break-words"
                        style={{
                            wordWrap: "break-word",
                            whiteSpace: "normal",
                            overflowWrap: "break-word",
                        }}
                    >
                        {nama}
                    </span>
                    <span className="flex-1 mr-[32px] ml-2 pl-[1px] min-w-[100px] max-w-[125px] break-words text-center"
                        style={{
                            wordWrap: "break-word",
                            whiteSpace: "normal",
                            overflowWrap: "break-word",
                        }}
                    >
                        {nim}
                    </span>
                    <span className="flex-1 mr-[50px] ml-2 pl-[1px] min-w-[80px] max-w-[90px] text-center">{kelas}</span>
                    <span className="flex-1 mr-[58px] ml-2 pl-[1px] min-w-[60px] max-w-[80px] text-center">{nilai}</span>
                </div>
            </div>
        );
    };

    return (
        <div className="bg-white rounded-lg py-4 px-4 max-w-4xl">
            <div className="bg-deepForestGreen rounded-lg py-2 px-2">
                <div className="flex mr-10 ml-6 items-center">
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 flex-none w-[45px]">
                        <h1 className="font-bold text-white text-center">Rank</h1>
                    </div>
                    <div className="ml-[34px] bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 flex-1">
                        <h1 className="font-bold text-white text-center">Nama</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 flex-1">
                        <h1 className="font-bold text-white text-center">NIM</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 flex-1">
                        <h1 className="font-bold text-white text-center">Kelas</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 flex-1">
                        <h1 className="font-bold text-white text-center">Nilai</h1>
                    </div>
                </div>
            </div>
            <div className="mt-4 mx-auto max-w-[790px] max-h-[355px] overflow-y-auto">
                {rows.map((row, index) => (
                    <RowComponent
                        key={index}
                        nama={row.nama}
                        nim={row.nim}
                        kelas={row.kelas}
                        nilai={row.nilai}
                        index={index}
                    />
                ))}
            </div>
        </div>
    );
}