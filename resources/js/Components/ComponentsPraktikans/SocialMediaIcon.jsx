export default function SocialMediaIcon({ href, src, alt }) {
    return (
        <a 
            href={href} 
            target="_blank" 
            rel="noopener noreferrer"
        >
            <img 
                className="w-auto h-8 mx-4 cursor-pointer hover:scale-90 transition-transform duration-300" 
                src={src} 
                alt={alt} 
            />
        </a>
    );
}