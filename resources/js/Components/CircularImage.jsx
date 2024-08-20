import React from "react";

export default function CircularImage({
    src,
    alt = "",
    className = "",
    ...props
}) {
    return (
        <div
            className={`bg-white w-[123px] h-[123px] mx-auto rounded-full shadow-lg flex justify-center items-center ${className}`}
            {...props}
        >
            <img
                className="w-full h-full object-cover rounded-full"
                src={src}
                alt={alt}
            />
        </div>
    );
}
