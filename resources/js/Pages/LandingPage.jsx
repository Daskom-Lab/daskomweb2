import { Head } from '@inertiajs/react';
import LandingNavbar from '@/Components/ComponentsPraktikans/LandingNavbar';
import MainLanding from '@/Components/ComponentsPraktikans/MainLanding';
import LandingSosmed from '@/Components/ComponentsPraktikans/LandingSosmed';
import LandingFooter from '@/Components/ComponentsPraktikans/LandingFooter';

export default function LandingPage() {
    return (
        <>
            <Head title="Landing Page - Daskom Laboratory" />
            <LandingNavbar />
            <MainLanding />
            <LandingSosmed />
            <LandingFooter />
        </>
    );
}