import ContactDescription from '../../Components/ComponentsPraktikans/ContactDescription.jsx';
import Vector from '../../Components/ComponentsPraktikans/Vector.jsx';

export default function ContactPage({ setCurrentPage }) {
    return (
        <div className="bg-[#EBEBEB] flex mt-7 mx-auto rounded-lg shadow-xl max-w-4xl p-5">
            <ContactDescription setCurrentPage={setCurrentPage} />
            <Vector />
        </div>
    );
}