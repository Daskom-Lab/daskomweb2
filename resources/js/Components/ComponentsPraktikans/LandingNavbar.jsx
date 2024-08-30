import daskomLogo from '../../../assets/daskomLogoLandscape.svg';

export default function LandingNavbar({ setCurrentPage }) {
    return (
        <>
            <div className='flex mx-auto justify-between items-center h-5 px-4'>
                <a href="https://www.daskomlab.com/" target="_blank" rel="noopener noreferrer">
                    <img className='w-[140px] h-auto hover:drop-shadow-xl cursor-pointer' src={daskomLogo} alt="Daskom Logo" />
                </a>
                <ul className='flex'>
                    <li className='m-4 px-4 py-1 border-b-2 border-black font-bold cursor-pointer hover:scale-105 duration-300' onClick={() => setCurrentPage('contact')}>Contact</li>
                    <li className='m-4 px-4 py-1 border-2 rounded bg-[#304D30] shadow-sm shadow-black text-white font-bold cursor-pointer hover:scale-95 duration-300' onClick={() => setCurrentPage('about')}>About</li>
                </ul>
            </div>
        </>
    );
}