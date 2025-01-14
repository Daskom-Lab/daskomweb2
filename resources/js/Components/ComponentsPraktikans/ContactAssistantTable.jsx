import profileImage from '../../../assets/daskom.svg';

export default function ContactAssistantTable() {
    const rows = [
        { nama: "Fauzan, Muhammad Zaidan", kode: "| FYN", wa: "082123456789", line: "@____ea", ig: "@zaidnfz_" },
        { nama: "Muh Zaidan Fauzan", kode: "| FYN", wa: "0821-2345-67891", line: "@____ea", ig: "@zaidnfz_" },
        { nama: "Dhea Aisyah Putri", kode: "| FYN", wa: "082123456789", line: "@____eaaaaaaaaaaaa", ig: "@zaidnfz_" },
        { nama: "Muh Zaidan Fauzan", kode: "| WWW", wa: "082123456789", line: "@____ea", ig: "@zaidnfz_" },
        { nama: "Muh Zaidan Fauzan", kode: "| QGW", wa: "082123456789", line: "@____ea", ig: "@zaidnfz_`111111" },
        { nama: "Fauzan, Muhammad Zaidan Daskom Lab FYN", kode: "| FYN", wa: "082123456789", line: "@____ea", ig: "@zaidnfz_" },
        { nama: "Muh Zaidan Fauzan", kode: "| FYN", wa: "082123456789", line: "@____ea", ig: "@zaidnfz_" },
        { nama: "Muh Zaidan Fauzan", kode: "| FYN", wa: "082123456789", line: "@____ea", ig: "@zaidnfz_" }
    ];

    const RowComponent = ({ nama, kode, wa, line, ig }) => (
        <div className="border-b border-transparent mb-1">
            <div className="border-2 border-black flex items-center justify-between px-2 py-1 bg-white text-sm font-semibold shadow-sm shadow-black">
                <div className="flex items-center space-x-4">
                    <div className="ml-1 w-12 h-12 rounded-full overflow-hidden flex justify-center items-center">
                        <img 
                            src={profileImage} 
                            alt="Profile" 
                            className="w-full h-full object-cover"
                            style={{ objectPosition: 'top' }} 
                        />
                    </div>
                    <span 
                        className="min-w-[145px] max-w-[146px] text-left break-words"
                        style={{
                            wordWrap: "break-word",
                            whiteSpace: "normal",
                            overflowWrap: "break-word",
                        }}
                    >
                        {nama}
                    </span>
                </div>
                <span className="flex-1 ml-[65px] pl-[1px] min-w-[48px] max-w-[55px]">{kode}</span>
                <span className="flex-1 ml-[48px] mr-[15px] min-w-[100px] max-w-[120px] text-center">{wa}</span>
                <span className="flex-1 ml-[15px] min-w-[40px] max-w-[115px] break-words text-center"
                style={{
                    wordWrap: "break-word",
                    whiteSpace: "normal",
                    overflowWrap: "break-word",
                }}
                >
                    {line}
                </span>
                <span className="flex-1 ml-[29px] mr-[40px] min-w-[40px] max-w-[115px]break-words text-center"
                style={{
                    wordWrap: "break-word",
                    whiteSpace: "normal",
                    overflowWrap: "break-word",
                }}
                >
                    {ig}
                </span>
            </div>
        </div>
    );

    return (
        <div className="bg-white rounded-lg py-4 px-4 max-w-4xl">
            <div className="bg-deepForestGreen rounded-sm py-2 px-2">
                <div className="flex ml-[80px] mr-[50px] items-center justify-evenly">
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 flex-1">
                        <h1 className="ml-[-15px] font-bold text-white text-center">Nama</h1>
                    </div>
                    <div className="ml-4 bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 flex-1">
                        <h1 className="font-bold text-white text-center">Kode</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 flex-1">
                        <h1 className="font-bold text-white text-center">WhatsApp</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 flex-1">
                        <h1 className="font-bold text-white text-center">ID Line</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 flex-1">
                        <h1 className="font-bold text-white text-center">Instagram</h1>
                    </div>
                </div>
            </div>
            <div className="mt-4 mx-auto max-w-[850px] max-h-[400px] overflow-y-auto">
                {rows.map((row, index) => (
                    <RowComponent
                        key={index}
                        nama={row.nama}
                        kode={row.kode}
                        wa={row.wa}
                        line={row.line}
                        ig={row.ig}
                    />
                ))}
            </div>
        </div>
    );
}