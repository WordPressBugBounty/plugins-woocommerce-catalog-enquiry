import { useState, useEffect } from 'react';
import { __ } from '@wordpress/i18n';

const Recaptcha = (props) => {
    const { captchaValid } = props;
    const [securityCode, setSecurityCode] = useState('');
    const [userInput, setUserInput] = useState('');
    const [isCaptchaValid, setIsCaptchaValid] = useState(true);

    useEffect(() => {
        // Generate a random 6-digit code
        const generateCode = () => {
            return Math.floor(100000 + Math.random() * 900000).toString();
        };

        setSecurityCode(generateCode());
    }, []);

    const captchCheck = (e) => {
        e.preventDefault();
        let value = e.target.value;
        setUserInput(value);

        // Check if the input matches the generated security code
        const isValid = value === securityCode;
        setIsCaptchaValid(isValid); 
        captchaValid(isValid);
    };

    return (
        <>
            <input
                type="text"
                id="securityCode"
                name="securityCode"
                onChange={captchCheck}
                value={userInput}
                placeholder="Enter security code"
            />
            <p>{ __('Your security code is:', 'catalogx') } { securityCode }</p>
            
            {!isCaptchaValid && (
                <p style={{ color: 'red' }}>
                { __('Invalid security code, please try again.', 'catalogx') }
                </p>
            )}
        </>
    );
}

export default Recaptcha;
