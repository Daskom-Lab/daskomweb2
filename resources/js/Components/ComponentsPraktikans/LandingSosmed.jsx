import { socialMediaLinks } from './SocialMediaData.jsx';
import SocialMediaIcon from './SocialMediaIcon.jsx';

export default function LandingSosmed() {
    return (
        <div className='relative'>
            <div className='flex absolute left-1/2 transform -translate-x-1/2 -top-3'>
                {socialMediaLinks.map((link, index) => (
                    <SocialMediaIcon key={index} href={link.href} src={link.src} alt={link.alt} />
                ))}
            </div>
        </div>
    );
}