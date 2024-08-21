import React, { useState } from 'react';
import axios from 'axios';

const HeroMenu = ({ hero, onClose, onUpdate }) => {
    const [localHero, setLocalHero] = useState(hero);

    const handleChange = (e) => {
        setLocalHero({
            ...localHero,
            [e.target.name]: e.target.value
        });
    };

    const handleSubmit = async () => {
        await axios.put(`http://127.0.0.1:8000/api/heroes/${hero.id}`, localHero);
        onUpdate(localHero);
        onClose();
    };

    return (
        <div className="hero-menu" style={{ position: 'absolute', top: hero.y, left: hero.x + 50 }}>
            <label>
                Color:
                <input
                    type="color"
                    name="color"
                    value={localHero.color}
                    onChange={handleChange}
                />
            </label>
            <label>
                Spell Color:
                <input
                    type="color"
                    name="spellColor"
                    value={localHero.spellColor}
                    onChange={(e) => {
                        setLocalHero({ ...localHero, spellColor: e.target.value });
                    }}
                />
            </label>
            <label>
                Speed:
                <input
                    type="range"
                    name="speed"
                    min="0.5"
                    max="5"
                    step="0.1"
                    value={localHero.speed}
                    onChange={handleChange}
                />
            </label>
            <label>
                Fire Rate:
                <input
                    type="range"
                    name="fire_rate"
                    min="10"
                    max="50"
                    step="0.1"
                    value={localHero.fire_rate}
                    onChange={handleChange}
                />
            </label>
            <button onClick={handleSubmit}>Save</button>
            <button onClick={onClose}>Close</button>
        </div>
    );
};

export default HeroMenu;
