import { useState } from "react";
import notificationIcon from "../../../assets/Icon-Notification.svg";
import CloseButton from "../CloseButton";

export default function PraktikanAnnouncement() {
    // State to manage popup visibility
    const [isPopupOpen, setIsPopupOpen] = useState(false);
    const isAnnouncementExist = false;

    // Function to open the popup
    const openPopup = () => {
        setIsPopupOpen(true);
    };

    // Function to close the popup
    const closePopup = () => {
        setIsPopupOpen(false);
    };

    // dummy message
    let message =
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus luctus urna sed urna ultricies ac tempor dui sagittis. In condimentum facilisis porta. Sed nec diam eu diam mattis viverra. Nulla fringilla, orci ac euismod semper, magna diam porttitor mauris, quis sollicitudin sapien justo in libero. Fusce varius, ligula non tempus aliquam, nunc turpis ullamcorper nibh, in tempus sapien eros vitae ligula. Aliquam erat volutpat. Ut adipiscing porttitor metus, a malesuada neque ultricies vel. Duis consequat vehicula dui, sit amet tincidunt lorem tempor ut. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus luctus urna sed urna ultricies ac tempor dui sagittis. In condimentum facilisis porta. Sed nec diam eu diam mattis viverra. Nulla fringilla, orci ac euismod semper, magna diam porttitor mauris, quis sollicitudin sapien justo in libero. Fusce varius, ligula non tempus aliquam, nunc turpis ullamcorper nibh, in tempus sapien eros vitae ligula. Aliquam erat volutpat. Ut adipiscing porttitor metus, a malesuada neque ultricies vel. Duis consequat vehicula dui, sit amet tincidunt lorem tempor ut.";

    return (
        <>
            <div className="absolute right-0 top-0">
                <button onClick={openPopup} className="mr-10 mt-3">
                    <img
                        className="w-12"
                        src={notificationIcon}
                        alt="notification"
                    />
                </button>
            </div>
            {isPopupOpen && (
                <div className="absolute z-40 h-screen w-screen bg-black bg-opacity-60 flex justify-center items-center">
                    <div className="bg-white w-[440px] h-[550px] rounded-md flex flex-col">
                        <div className="w-full text-right">
                            <CloseButton buttonAction={closePopup} />
                        </div>
                        {isAnnouncementExist ? (
                            <div className="font-poppins flex flex-col flex-grow p-4">
                                <h2 className="text-[#D61B00] text-center text-2xl font-bold">
                                    Pengumuman
                                </h2>
                                <h1 className="text-black text-center text-3xl font-bold my-1">
                                    Praktikum Pengganti
                                </h1>
                                <hr className="w-[400px] mx-auto border-2 border-black my-6 rounded-sm" />
                                <div className="flex-grow overflow-auto max-h-[340px] p-2">
                                    <p className="text-justify">{message}</p>
                                </div>
                            </div>
                        ) : (
                            <div className="font-poppins flex flex-col justify-center items-center flex-grow ">
                                <h2 className="text-[#D61B00] text-2xl font-bold">
                                    Tidak Ada Pengumuman
                                </h2>
                                <h1 className="text-black text-3xl font-bold my-1">
                                    Praktikum Pengganti
                                </h1>
                            </div>
                        )}
                    </div>
                </div>
            )}
        </>
    );
}
