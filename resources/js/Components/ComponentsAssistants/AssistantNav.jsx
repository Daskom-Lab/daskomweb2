import profileIcon from "../../../assets/nav/Icon-Profile.svg";
import praktikumIcon from "../../../assets/nav/Icon-Praktikum.svg";
import nilaiIcon from "../../../assets/nav/Icon-Nilai.svg";
import historyIcon from "../../../assets/nav/Icon-History.svg";
import laporanIcon from "../../../assets/nav/Icon-Laporan.svg";
import inputSoalIcon from "../../../assets/nav/Icon-InputSoal.svg";
import kirimLaporanIcon from "../../../assets/nav/Icon-InputLaporan.svg";
import ratingIcon from "../../../assets/nav/Icon-Rating.svg";
import rankingIcon from "../../../assets/nav/Icon-Ranking.svg";
import pollingIcon from "../../../assets/nav/Icon-Polling.svg";
import plottingIcon from "../../../assets/nav/Icon-Plotting.svg";
import piketLabIcon from "../../../assets/nav/Icon-Piket.svg";
import praktikanIcon from "../../../assets/nav/Icon-Praktikan.svg";
import pelanggaranIcon from "../../../assets/nav/Icon-Pelanggaran.svg";
import konfigurasiIcon from "../../../assets/nav/Icon-Konfigurasi.svg";
import announcementIcon from "../../../assets/nav/Icon-Annoucement.svg";
import changePassIcon from "../../../assets/nav/Icon-GantiPassword.svg";
import logoutIcon from "../../../assets/nav/Icon-Logout.svg";

function AssistantNav() {
    return (
        <nav className="h-screen flex items-center">
            <div className="left-0 top-0 h-[91vh] w-[230px] bg-forestGreen text-left text-white m-[27px] font-poppins font-bold overflow-y-auto scrollbar-hidden scroll-smooth rounded-md ">
                <div className="">
                    <ul className="py-5">
                        <li>
                            <a
                                href="/"
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={profileIcon}
                                    alt="profile"
                                />
                                <span className="self-center text-sm ml-3">
                                    Profile
                                </span>
                            </a>
                        </li>

                        <li>
                            <a
                                href="/"
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={praktikumIcon}
                                    alt="praktikum"
                                />
                                <span className="self-center text-sm ml-3">
                                    Praktikum
                                </span>
                            </a>
                        </li>

                        <li>
                            <a
                                href=""
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={nilaiIcon}
                                    alt="nilai"
                                />
                                <span className="self-center text-sm ml-3">
                                    Nilai
                                </span>
                            </a>
                        </li>

                        <li>
                            <a
                                href=""
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={historyIcon}
                                    alt="history"
                                />
                                <span className="self-center text-sm ml-3">
                                    History
                                </span>
                            </a>
                        </li>

                        <li>
                            <a
                                href=""
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={laporanIcon}
                                    alt="laporan"
                                />
                                <span className="self-center text-sm ml-3">
                                    Laporan
                                </span>
                            </a>
                        </li>

                        <li>
                            <a
                                href=""
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={inputSoalIcon}
                                    alt="input soal"
                                />
                                <span className="self-center text-sm ml-3">
                                    Input Soal
                                </span>
                            </a>
                        </li>

                        <li>
                            <a
                                href=""
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={kirimLaporanIcon}
                                    alt="Kirim Laporan"
                                />
                                <span className="self-center text-sm ml-3">
                                    Kirim Laporan
                                </span>
                            </a>
                        </li>

                        <li>
                            <a
                                href=""
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={ratingIcon}
                                    alt="rating"
                                />
                                <span className="self-center text-sm ml-3">
                                    Rating
                                </span>
                            </a>
                        </li>

                        <li>
                            <a
                                href=""
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={rankingIcon}
                                    alt="ranking"
                                />
                                <span className="self-center text-sm ml-3">
                                    Ranking
                                </span>
                            </a>
                        </li>

                        <li>
                            <a
                                href=""
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={pollingIcon}
                                    alt="polling"
                                />
                                <span className="self-center text-sm ml-3">
                                    Polling
                                </span>
                            </a>
                        </li>

                        <li>
                            <a
                                href=""
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={plottingIcon}
                                    alt="plotting"
                                />
                                <span className="self-center text-sm ml-3">
                                    Plotting
                                </span>
                            </a>
                        </li>

                        <li>
                            <a
                                href=""
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={piketLabIcon}
                                    alt="piket laboratorium"
                                />
                                <span className="self-center text-sm ml-3">
                                    Piket Laboratorium
                                </span>
                            </a>
                        </li>

                        <li>
                            <a
                                href=""
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={praktikanIcon}
                                    alt="praktikan"
                                />
                                <span className="self-center text-sm ml-3">
                                    Praktikan
                                </span>
                            </a>
                        </li>

                        <li>
                            <a
                                href=""
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={pelanggaranIcon}
                                    alt="pelanggaran"
                                />
                                <span className="self-center text-sm ml-3">
                                    Pelanggaran
                                </span>
                            </a>
                        </li>

                        <li>
                            <a
                                href=""
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={konfigurasiIcon}
                                    alt="konfigurasi"
                                />
                                <span className="self-center text-sm ml-3">
                                    Konfigurasi
                                </span>
                            </a>
                        </li>

                        <li>
                            <a
                                href=""
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={announcementIcon}
                                    alt="announcement"
                                />
                                <span className="self-center text-sm ml-3">
                                    Announcement
                                </span>
                            </a>
                        </li>
                    </ul>

                    <ul className="py-5">
                        <li>
                            <a
                                href=""
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={changePassIcon}
                                    alt="change password"
                                />
                                <span className="self-center text-sm ml-3">
                                    Change Password
                                </span>
                            </a>
                        </li>

                        <li>
                            <a
                                href=""
                                className="flex py-3 px-5 hover:bg-darkGreen"
                            >
                                <img
                                    className="w-6"
                                    src={logoutIcon}
                                    alt="logout"
                                />
                                <span className="self-center text-sm ml-3">
                                    Logout
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    );
}

export default AssistantNav;
