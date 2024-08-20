import daskomIcon from "../../../../resources/assets/daskom.svg";
import CircularImage from "../CircularImage";

export default function CardPraktikan() {

    //data variable
    let name = "Dhea Aisyah Putri";
    let nim = "1104223146";
    let kelas = "TF-46-04";
    let notel = "081250770473";
    let email = "dheaaisyahputri09@gmail.com";
    let major = "S1 Teknik Fisika";

    return (
        <>
            <div className="my-auto mx-auto font-poppins">
                <div className=" bg-softIvory  h-[436px] w-[352.8px] shadow-xl rounded-lg pt-5">
                    <CircularImage src={daskomIcon} alt="Logo Daskom" />

                    <div className="flex justify-center mb-[10px] mt-[16px]">
                        <h1 className="font-poppins font-bold text-lg max-w-[320px] truncate">
                            {name}
                        </h1>
                    </div>

                    <div className="flex ">
                        <ul className="mx-[17px] mb-[20px] font-poppins text-sm ">
                            <li className="my-[4px] max-w-[320px] truncate">
                                NIM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:{" "}
                                {nim}
                            </li>
                            <li className="my-[4px] max-w-[320px] truncate">
                                Kelas &nbsp;&nbsp;&nbsp;&nbsp;: {kelas}
                            </li>
                            <li className="my-[4px] max-w-[320px] truncate">
                                No. Telp : {notel}
                            </li>
                            <li className="my-[4px] max-w-[320px] truncate">
                                Email &nbsp;&nbsp;&nbsp;&nbsp;: {email}
                            </li>
                        </ul>
                    </div>

                    <div className=" my-[20px] h-[27.5px] mx-[17px] bg-darkGreen rounded-md">
                        <h1 className="text-center text-white font-poppins font-bold text-lg">
                            {major}
                        </h1>
                    </div>
                </div>
            </div>
        </>
    );
}
