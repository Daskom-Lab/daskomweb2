import ilustrasi1 from '../../../assets/ilustrasi1.svg';

export default function Vector({ size = 'w-1/2', alt = "Illustration" }) {
    return (
        <div className={`flex ${size} p-3`}>
            <img className="w-full h-auto rounded-lg" src={ilustrasi1} alt="Placeholder" />
        </div>
    );
}