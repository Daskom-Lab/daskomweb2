import { Link } from '@inertiajs/react';

export default function MainLanding() {
    return (
        <div className="flex flex-grow items-center justify-center min-h-[calc(100vh-14rem)]">
            <div className="text-center">
                <h1 className="text-deepForestGreen font-bold text-3xl">Welcome To</h1>
                <h1 className="text-deepForestGreen font-bold text-[55px]">Daskom Laboratory</h1>
                <Link href="login">
                    <button className="mt-6 px-12 py-2 bg-deepForestGreen text-xl text-white font-bold border-4 border-white rounded-2xl shadow-lg shadow-black hover:bg-darkOliveGreen transition duration-300">
                        Get Started
                    </button>
                </Link>
            </div>
        </div>
    );
}