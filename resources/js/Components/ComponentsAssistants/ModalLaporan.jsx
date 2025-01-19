import closeIcon from "../../../assets/modal/iconClose.svg"

export default function ModalLaporan({ onClose }) {
    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div className="bg-white p-6 rounded shadow-lg w-3/4 relative">
                {/* Tombol X untuk tutup */}
                <button
                    onClick={onClose}
                    className="absolute top-2 right-2 flex justify-center items-center"
                >
                    <img className="w-9" src={closeIcon} alt="closeIcon" />
                </button>

                {/* kelas - tanggal */}
                <h4 className="text-lg text-darkBrown font-semibold mb-4">[ TF-46-04 ] Sabtu 2, 26/06/24, 11:34:57</h4>

                {/* Garis pemisah */}
                <hr className="border-t-2 border-darkBrown mb-4" />

                {/* isi laporan + judul */}
                <div className="max-h-96 overflow-y-auto">
                    <h2 className="text-xl font-bold text-black underline text-center mb-4">Pengantar Algoritma dan Pemrograman</h2>
                    <p className="mt-6">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex tempore perferendis expedita! Ipsum rem excepturi sunt voluptatum vero, maiores inventore nisi nihil, temporibus unde eveniet voluptates animi necessitatibus neque porro.
                        <br /> Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptas iure sit, nihil est qui voluptatibus accusantium. Iusto, necessitatibus! Ex sunt non asperiores sint possimus. Incidunt est esse culpa voluptatum officiis. <br />Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic deserunt asperiores atque animi modi sapiente magnam nihil consequatur, odit natus qui? Qui nesciunt necessitatibus dolorum asperiores expedita aliquam officiis nulla? <br />
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex tempore perferendis expedita! Ipsum rem excepturi sunt voluptatum vero, maiores inventore nisi nihil, temporibus unde eveniet voluptates animi necessitatibus neque porro.
                        <br /> Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptas iure sit, nihil est qui voluptatibus accusantium. Iusto, necessitatibus! Ex sunt non asperiores sint possimus. Incidunt est esse culpa voluptatum officiis. <br />Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic deserunt asperiores atque animi modi sapiente magnam nihil consequatur, odit natus qui? Qui nesciunt necessitatibus dolorum asperiores expedita aliquam officiis nulla? <br />
                        <br /> Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptas iure sit, nihil est qui voluptatibus accusantium. Iusto, necessitatibus! Ex sunt non asperiores sint possimus. Incidunt est esse culpa voluptatum officiis. <br />Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic deserunt asperiores atque animi modi sapiente magnam nihil consequatur, odit natus qui? Qui nesciunt necessitatibus dolorum asperiores expedita aliquam officiis nulla? <br />
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex tempore perferendis expedita! Ipsum rem excepturi sunt voluptatum vero, maiores inventore nisi nihil, temporibus unde eveniet voluptates animi necessitatibus neque porro.
                        <br /> Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptas iure sit, nihil est qui voluptatibus accusantium. Iusto, necessitatibus! Ex sunt non asperiores sint possimus. Incidunt est esse culpa voluptatum officiis. <br />Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic deserunt asperiores atque animi modi sapiente magnam nihil consequatur, odit natus qui? Qui nesciunt necessitatibus dolorum asperiores expedita aliquam officiis nulla? <br />
                    </p>
                </div>

            </div>
        </div>
    );
}
