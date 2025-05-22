import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import './style.css';

registerBlockType('c2c/click2chat-button', {
    title: __('C2C Chat Button', 'c2c'),
    icon: 'format-chat',
    category: 'widgets',
    edit: () => {
        return (
            <div className="c2c-preview">
                <strong>WhatsApp Button:</strong> Appears on the frontend with saved plugin settings.
            </div>
        );
    },
    save: () => {
        return null; // Render via PHP
    },
});
