import React, { useRef, useEffect, useState } from 'react';
import axios from 'axios';
import HeroMenu from './HeroMenu';

const Canvas = () => {
    const canvasRef = useRef(null);
    const [heroes, setHeroes] = useState([]);
    const [spells, setSpells] = useState([]);
    const [score, setScore] = useState({ hero1: 0, hero2: 0 });
    const [selectedHero, setSelectedHero] = useState(null);

    useEffect(() => {
        const fetchHeroes = async () => {
            const response = await axios.get('http://127.0.0.1:8000/api/heroes');
            setHeroes(response.data.map(hero => ({
                ...hero,
                x: hero.id === 1 ? 50 : 750,
                y: 300,
                direction: 1,
                spellColor: hero.color,
                nextFire: Date.now() + 5000 / hero.fire_rate,  // время следующего выстрела
            })));
        };

        fetchHeroes();
    }, []);

    useEffect(() => {
        const canvas = canvasRef.current;
        const ctx = canvas.getContext('2d');

        const draw = () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Рисуем границы поля
            ctx.strokeStyle = '#000';
            ctx.lineWidth = 5;
            ctx.strokeRect(0, 0, canvas.width, canvas.height);

            // Рисуем героев
            heroes.forEach(hero => {
                ctx.beginPath();
                ctx.arc(hero.x, hero.y, 20, 0, 2 * Math.PI);
                ctx.fillStyle = hero.color;
                ctx.fill();
            });

            // Рисуем заклинания
            spells.forEach(spell => {
                ctx.beginPath();
                ctx.arc(spell.x, spell.y, 10, 0, 2 * Math.PI);
                ctx.fillStyle = spell.color;
                ctx.fill();
            });

            // Отображение счета по середине экрана
            ctx.font = "20px Arial";
            ctx.fillStyle = "#000";
            const middleX = canvas.width / 2;
            ctx.fillText(`Hero 1: ${score.hero1}`, middleX - 150, 30);
            ctx.fillText(`Hero 2: ${score.hero2}`, middleX + 50, 30);

            requestAnimationFrame(draw);
        };

        draw();
    }, [heroes, spells, score]);

    useEffect(() => {
        const canvas = canvasRef.current;

        const moveHeroes = () => {
            setHeroes(prevHeroes =>
                prevHeroes.map(hero => {
                    let newY = hero.y + hero.speed * hero.direction;
                    if (newY <= 20 || newY >= canvas.height - 20) {
                        hero.direction *= -1;
                        newY = hero.y + hero.speed * hero.direction;
                    }
                    return { ...hero, y: newY };
                })
            );
        };

        const handleMouseMove = (e) => {
            const rect = canvas.getBoundingClientRect();
            const mouseY = e.clientY - rect.top;

            setHeroes(prevHeroes =>
                prevHeroes.map(hero => {
                    if (Math.abs(hero.y - mouseY) < 30) {
                        return { ...hero, y: hero.y - hero.speed * hero.direction };
                    }
                    return hero;
                })
            );
        };

        const fireSpells = () => {
            const currentTime = Date.now();

            setHeroes(prevHeroes => prevHeroes.map(hero => {
                if (currentTime >= hero.nextFire) {
                    // Герой стреляет
                    setSpells(prevSpells => [
                        ...prevSpells,
                        {
                            x: hero.id === 1 ? hero.x + 20 : hero.x - 20,
                            y: hero.y,
                            speed: hero.id === 1 ? 5 : -5,
                            color: hero.spellColor,
                            owner: hero.id
                        }
                    ]);
                    // Обновляем время следующего выстрела
                    return {
                        ...hero,
                        nextFire: currentTime + 5000 / hero.fire_rate
                    };
                }
                return hero;
            }));
        };

        const moveSpells = () => {
            setSpells(prevSpells => {
                return prevSpells
                    .map(spell => ({
                        ...spell,
                        x: spell.x + spell.speed
                    }))
                    .filter(spell => {
                        // Проверка на столкновение с героями
                        const hitHero = heroes.find(hero =>
                            Math.hypot(hero.x - spell.x, hero.y - spell.y) < 20 && hero.id !== spell.owner
                        );

                        if (hitHero) {
                            setScore(prevScore => ({
                                ...prevScore,
                                [`hero${spell.owner}`]: prevScore[`hero${spell.owner}`] + 1
                            }));
                            return false; // Удаляем заклинание при попадании
                        }

                        // Удаляем заклинания, вышедшие за пределы поля
                        return spell.x > 0 && spell.x < canvas.width;
                    });
            });
        };

        canvas.addEventListener('mousemove', handleMouseMove);
        const heroInterval = setInterval(moveHeroes, 1000 / 60);
        const spellInterval = setInterval(moveSpells, 1000 / 60);
        const fireInterval = setInterval(fireSpells, 1000 / 60);  // Частота проверок на стрельбу

        return () => {
            clearInterval(heroInterval);
            clearInterval(spellInterval);
            clearInterval(fireInterval);
            canvas.removeEventListener('mousemove', handleMouseMove);
        };
    }, [heroes]);

    const handleCanvasClick = (e) => {
        const rect = canvasRef.current.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        const clickY = e.clientY - rect.top;

        const hero = heroes.find(h => {
            return Math.hypot(h.x - clickX, h.y - clickY) < 20;
        });

        if (hero) {
            setSelectedHero(hero);
        } else {
            setSelectedHero(null);
        }
    };

    return (
        <>
            <canvas ref={canvasRef} width={800} height={600} onClick={handleCanvasClick} />
            {selectedHero && (
                <HeroMenu
                    hero={selectedHero}
                    onClose={() => setSelectedHero(null)}
                    onUpdate={(updatedHero) => {
                        setHeroes(prevHeroes =>
                            prevHeroes.map(hero => hero.id === updatedHero.id ? updatedHero : hero)
                        );
                    }}
                />
            )}
        </>
    );
};

export default Canvas;
