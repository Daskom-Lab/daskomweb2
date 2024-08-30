export default function MainLanding({ setCurrentPage }) {
    return (
        <div className='flex flex-grow items-center justify-center min-h-[calc(100vh-11rem)]'>
            <div className='text-center'>
                <h1 className='text-[#304D30] font-bold text-3xl'>Welcome To</h1>
                <h1 className='text-[#304D30] font-bold text-[55px]'>Daskom Laboratory</h1>
                <button className='mt-6 px-12 py-2 bg-[#304D30] text-xl text-white font-bold border-4 border-white rounded-2xl shadow-lg shadow-black hover:bg-[#243622] transition duration-300' onClick={() => setCurrentPage('login')}>Get Started</button>
            </div>
        </div>
    );
}