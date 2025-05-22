import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import './style.css';

registerBlockType('wcb/whatsapp-chat-button', {
    title: __('WhatsApp Chat Button', 'wcb'),
    icon: 'format-chat',
    category: 'widgets',
    edit: () => {
        return (
            <div className="wcb-preview">
                <strong>WhatsApp Button:</strong> Appears on the frontend with saved plugin settings.
            </div>
        );
    },
    save: () => {
        return null; // Render via PHP
    },
});
