import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Canvas from './Canvas';
import HeroMenu from './HeroMenu';

const Game = () => {
    const [heroes, setHeroes] = useState([]);

    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/heroes')
            .then(response => setHeroes(response.data))
            .catch(error => console.error(error));
    }, []);

    const updateHero = (id, updates) => {
        axios.put(`http://127.0.0.1:8000/api/heroes/${id}`, updates)
            .then(response => {
                setHeroes(prevHeroes => prevHeroes.map(hero => hero.id === id ? response.data : hero));
            })
            .catch(error => console.error(error));
    };

    return (
        <div>
            <Canvas heroes={heroes} />
            <HeroMenu heroes={heroes} onUpdateHero={updateHero} />
        </div>
    );
};

export default Game;
