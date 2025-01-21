import ReactDOM from 'react-dom';
import iconClose from '../../../assets/modal/iconClose.svg';
import iconCloseHover from '../../../assets/modal/iconCloseHover.svg';

export default function Modal({ isOpen, onClose, children, width = 'w-full' }) {
    if (!isOpen) return null;

    return ReactDOM.createPortal(
        <div className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[9999]">
            <div className={`relative bg-softGray rounded-lg p-6 ${width} max-w-md mx-4 sm:mx-8`}>
                <button
                    className="absolute top-1 right-2 p-1"
                    onClick={() => {
                        onClose();
                    }}
                >
                    <img
                        className="w-full h-5 hover:opacity-80"
                        src={iconClose}
                        alt="Close"
                        onMouseOver={(e) => (e.currentTarget.src = iconCloseHover)}
                        onMouseOut={(e) => (e.currentTarget.src = iconClose)}
                    />
                </button>
                <div>{children}</div>
            </div>
        </div>,
        document.body
    );
}