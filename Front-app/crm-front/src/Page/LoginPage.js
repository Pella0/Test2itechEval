import React, { useState, useEffect } from 'react';
import axios from 'axios';

export default function LoginPage() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');

    useEffect(() => {
        if (localStorage.getItem('token')) {
            // Rediriger l'utilisateur vers la page de profil
            window.location.href = '/profile';
        }
    }, []);

    const handleEmailChange = (event) => {
        setEmail(event.target.value);
    };

    const handlePasswordChange = (event) => {
        setPassword(event.target.value);
    };

    const handleSubmit = (event) => {
        event.preventDefault();
        axios.post('/api/login', { email, password })
            .then(response => {
                localStorage.setItem('token', response.data.token);
                // Rediriger l'utilisateur vers la page de Dashboard
                window.location.href = '/dashboard';
            })
            .catch(error => {
                setError('Email ou mot de passe incorrect.');
            });
    };

    return (
        <form onSubmit={handleSubmit}>
            <div>
                <label htmlFor="email">Email:</label>
                <input type="email" id="email" value={email} onChange={handleEmailChange} required />
            </div>
            <div>
                <label htmlFor="password">Mot de passe:</label>
                <input type="password" id="password" value={password} onChange={handlePasswordChange} required />
            </div>
            {error && <p>{error}</p>}
            <button type="submit">Se connecter</button>
        </form>
    );
};
