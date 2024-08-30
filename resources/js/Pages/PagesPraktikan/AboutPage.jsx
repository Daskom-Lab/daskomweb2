import AboutDescription from '../../Components/ComponentsPraktikans/AboutDescription.jsx';
import Vector from '../../Components/ComponentsPraktikans/Vector.jsx';

export default function AboutPage({ setCurrentPage }){
    return (
        <>
            <div className="bg-[#EBEBEB] flex mt-7 mx-auto rounded-lg shadow-xl max-w-4xl min-h-[475px] p-5">
                <AboutDescription setCurrentPage={setCurrentPage} />
                <Vector />
            </div>
        </>
    );
}