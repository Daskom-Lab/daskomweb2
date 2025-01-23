import FormChangePassPraktikan from './FormChangePassPraktikan';
import FormTarikPraktikan from './FormTarikPraktikan';

export default function ContentSetPraktikan() {
    return (
        <div className="flex flex-col gap-9 p-6">
            {/* Form Change Password */}
            <FormChangePassPraktikan />

            {/* Form Tarik Praktikan */}
            <FormTarikPraktikan />
        </div>
    );
}
