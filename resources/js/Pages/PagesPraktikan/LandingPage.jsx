import LandingNavbar from '../../Components/ComponentsPraktikans/LandingNavbar.jsx';
import MainLanding from '../../Components/ComponentsPraktikans/MainLanding.jsx';
import LandingSosmed from '../../Components/ComponentsPraktikans/LandingSosmed.jsx';
import LandingFooter from '../../Components/ComponentsPraktikans/LandingFooter.jsx';

export default function LandingPage({ setCurrentPage }) {
    return (
        <>
            <LandingNavbar setCurrentPage={setCurrentPage} />
            <MainLanding setCurrentPage={setCurrentPage} />
            <LandingSosmed />
            <LandingFooter />
        </>
    );
}   