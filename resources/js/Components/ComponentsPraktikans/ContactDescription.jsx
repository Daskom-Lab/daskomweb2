import { contactData } from '../ComponentsAssistants/ContactData';

export default function ContactDescription() {
    return (
        <div className="w-1/2 py-5 px-10">
            {contactData.map((section, index) => (
                <div key={index}>
                    <h1 className="flex mt-2 mb-2 font-bold">{section.name}</h1>
                    {section.details.map((detail, detailIndex) => (
                        <div key={detailIndex} className="flex items-center mb-1">
                            <img className="w-auto h-7 mr-3" src={detail.src} alt={detail.alt} />
                            <span className="text-sm">{detail.text}</span>
                        </div>
                    ))}
                </div>
            ))}
        </div>
    );
}