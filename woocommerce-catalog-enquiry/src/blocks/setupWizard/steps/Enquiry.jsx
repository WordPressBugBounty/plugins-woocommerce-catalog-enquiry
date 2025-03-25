import React, { useState } from 'react';
import { getApiLink } from "../../../services/apiService";
import axios from 'axios';
import Loading from './Loading';

const Enquiry = (props) => {
    const { onNext, onPrev } = props;
    const [loading, setLoading] = useState(false);
    const [displayOption, setDisplayOption] = useState('popup');
    const [restrictUserEnquiry, setRestrictUserEnquiry] = useState([]);

    const handleRestrictUserEnquiryChange = (event) => {
        const { checked, name } = event.target;
        setRestrictUserEnquiry((prevState) =>
            checked ? [...prevState, name] : prevState.filter(value => value !== name)
        );
    };

    const saveEnquirySettings = () => {
        setLoading(true);
        const data = {
            action: 'enquiry',
            displayOption: displayOption,
            restrictUserEnquiry: restrictUserEnquiry
        };

        axios({
            method: "post",
            url: getApiLink('settings'),
            headers: { "X-WP-Nonce": appLocalizer.nonce },
            data: data
        }).then((response) => {
            setLoading(false);
            onNext();
        });
    };

    return (
        <section>
            <h2>Enquiry</h2>
            <article className='module-wrapper'>
                <div className='module-items'>
                    <div className="module-details">
                        <h3>Display Enquiry Form:</h3>
                        <p className='module-description'>
                        Select whether the form is displayed directly on the page or in a pop-up window.
                        </p>
                    </div>
                    <ul>
                        <li>
                            <input className="toggle-setting-form-input" type="radio" id="popup" name="approve_vendor" value="popup" checked={displayOption === 'popup'} />
                            <label for="popup" onClick={(e) => setDisplayOption('popup')}>Popup</label>
                        </li>
                        <li>
                            <input className="toggle-setting-form-input" type="radio" id="inline" name="approve_vendor" value="inline" checked={displayOption === 'inline'} />
                            <label for="inline" onClick={(e) => setDisplayOption('inline')}>Inline In-page</label>
                        </li>
                    </ul>
                </div>
            </article>
            <article className='module-wrapper'>
                <div className="module-items">
                    <div className="module-details">
                        <h3>Restrict for logged-in user</h3>
                        <p className='module-description'>
                            If enabled, non-logged-in users can't access the enquiry flow.
                        </p>
                    </div>
                    <div className='toggle-checkbox'>
                        <input
                            type="checkbox"
                            id="enquiry_logged_out"
                            name="enquiry_logged_out"
                            checked={restrictUserEnquiry.includes('enquiry_logged_out')}
                            onChange={handleRestrictUserEnquiryChange}
                        />
                        <label htmlFor='enquiry_logged_out'></label>
                    </div>
                </div>
            </article>

            <footer className='setup-footer-btn-wrapper'>
                <div>
                    <button className='footer-btn pre-btn' onClick={onPrev}>Prev</button>
                    <button className='footer-btn ' onClick={onNext}>Skip</button>
                </div>
                <button className='footer-btn next-btn' onClick={saveEnquirySettings}>Next</button>
            </footer>
            {loading && <Loading />}
        </section>
    );
};

export default Enquiry;
