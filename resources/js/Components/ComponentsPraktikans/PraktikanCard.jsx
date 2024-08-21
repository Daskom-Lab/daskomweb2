import daskomIcon from "../../../../resources/assets/daskom.svg";
import CircularImage from "../CircularImage";

export default function CardPraktikan() {
    //data variable
    let name = "John Doe";
    let nim = "1402214022";
    let kelas = "TF-46-INT";
    let notel = "14022";
    let email = "Johndoe@gmail.com";
    let major = "S3 Teknik Fisika";

    return (
        <>
            <div className="my-auto mx-auto font-poppins">
                <div className="bg-softIvory h-[436px] w-[352.8px] shadow-xl rounded-lg pt-5">
                    <CircularImage src={daskomIcon} alt="Logo Daskom" />

                    <div className="flex justify-center mb-[10px] mt-[16px]">
                        <h1 className="font-poppins font-bold text-lg max-w-[320px] truncate">
                            {name}
                        </h1>
                    </div>

                    <div className="flex ">
                        <ul className="mx-[17px] mb-[20px] font-poppins text-sm">
                            <li className="my-[4px]">
                                NIM
                            </li>
                            <li className="my-[4px]">
                                Kelas
                            </li>
                            <li className="my-[4px]">
                                No. Telp
                            </li>
                            <li className="my-[4px]">
                                Email
                            </li>
                        </ul>
                        <ul className="mx-[17px] mb-[20px] font-poppins text-sm">
                            <li className="my-[4px] max-w-[320px] truncate">
                                : {nim}
                            </li>
                            <li className="my-[4px] max-w-[230px] truncate">
                                : {kelas}
                            </li>
                            <li className="my-[4px] max-w-[230px] truncate">
                                : {notel}
                            </li>
                            <li className="my-[4px] max-w-[230px] truncate">
                                : {email}
                            </li>
                        </ul>
                    </div>

                    <div className="my-[20px] h-[27.5px] mx-[17px] bg-darkGreen rounded-md">
                        <h1 className="text-center text-white font-poppins font-bold text-lg">
                            {major}
                        </h1>
                    </div>
                </div>
            </div>
        </>
    );
}
