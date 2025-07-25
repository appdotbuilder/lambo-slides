import React, { useState, useEffect } from 'react';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/react';

interface Props {
    completionCount: number;
    [key: string]: unknown;
}

interface Slide {
    id: number;
    title: string;
    content: string;
    type: 'joke' | 'title' | 'end';
}

const slides: Slide[] = [
    {
        id: 1,
        title: "🏎️ Lamborghini Jokes Presentation",
        content: "Get ready for some high-performance humor!",
        type: 'title'
    },
    {
        id: 2,
        title: "Joke #1",
        content: "Why don't Lamborghinis ever get parking tickets?\n\nBecause they're always in a different postal code by the time the officer writes it!",
        type: 'joke'
    },
    {
        id: 3,
        title: "Joke #2", 
        content: "What's the difference between a Lamborghini and a porcupine?\n\nWith a porcupine, the pricks are on the outside!",
        type: 'joke'
    },
    {
        id: 4,
        title: "Joke #3",
        content: "Why did the Lamborghini break up with the Ferrari?\n\nBecause it was tired of being in a relationship that was all about speed and no substance... just kidding, they both have trust issues with corners!",
        type: 'joke'
    },
    {
        id: 5,
        title: "Joke #4",
        content: "How do you know someone owns a Lamborghini?\n\nDon't worry, they'll tell you within the first 30 seconds of meeting them!",
        type: 'joke'
    },
    {
        id: 6,
        title: "Thanks for watching! 🎉",
        content: "Hope these jokes revved up your day!\n\nYou've completed the presentation.",
        type: 'end'
    }
];

export default function Presentation({ completionCount }: Props) {
    const [currentSlide, setCurrentSlide] = useState(0);
    const [sessionId] = useState(() => Math.random().toString(36).substring(2, 15));
    const [hasCompleted, setHasCompleted] = useState(false);

    const isFirstSlide = currentSlide === 0;
    const isLastSlide = currentSlide === slides.length - 1;

    const handleNext = () => {
        if (!isLastSlide) {
            setCurrentSlide(prev => prev + 1);
        }
    };

    const handlePrevious = () => {
        if (!isFirstSlide) {
            setCurrentSlide(prev => prev - 1);
        }
    };

    const handleComplete = () => {
        if (!hasCompleted && isLastSlide) {
            setHasCompleted(true);
            router.post(route('presentation.complete'), {
                session_id: sessionId
            }, {
                preserveState: true,
                preserveScroll: true
            });
        }
    };

    useEffect(() => {
        if (isLastSlide && !hasCompleted) {
            handleComplete();
        }
    }, [currentSlide, isLastSlide, hasCompleted]);

    const slide = slides[currentSlide];

    return (
        <div className="min-h-screen bg-gray-50 py-8">
            {/* Completion Counter */}
            <div className="fixed top-4 right-4 bg-white rounded-lg shadow-lg px-4 py-2 border-2 border-red-600">
                <div className="text-sm font-medium text-gray-700">
                    Presentations Completed
                </div>
                <div className="text-2xl font-bold text-red-600 text-center">
                    {completionCount}
                </div>
            </div>

            {/* Main Presentation Area */}
            <div className="container mx-auto px-4 max-w-4xl">
                <div className="bg-white rounded-xl shadow-2xl min-h-[600px] flex flex-col">
                    {/* Slide Content */}
                    <div className="flex-1 p-12 flex flex-col justify-center">
                        <div className="text-center">
                            <h1 className={`font-bold mb-8 ${
                                slide.type === 'title' 
                                    ? 'text-5xl text-red-600' 
                                    : 'text-4xl text-gray-800'
                            }`}>
                                {slide.title}
                            </h1>
                            
                            <div className={`whitespace-pre-line leading-relaxed ${
                                slide.type === 'title' 
                                    ? 'text-2xl text-gray-600' 
                                    : slide.type === 'end'
                                        ? 'text-2xl text-red-600 font-medium'
                                        : 'text-xl text-gray-700'
                            }`}>
                                {slide.content}
                            </div>
                        </div>
                    </div>

                    {/* Navigation */}
                    <div className="border-t border-gray-200 p-6">
                        <div className="flex justify-between items-center">
                            <Button
                                onClick={handlePrevious}
                                disabled={isFirstSlide}
                                variant="outline"
                                className="px-6 py-3 border-red-600 text-red-600 hover:bg-red-50 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                ← Previous
                            </Button>

                            {/* Slide Indicator */}
                            <div className="flex items-center space-x-2">
                                {slides.map((_, index) => (
                                    <div
                                        key={index}
                                        className={`w-3 h-3 rounded-full ${
                                            index === currentSlide
                                                ? 'bg-red-600'
                                                : index < currentSlide
                                                    ? 'bg-red-300'
                                                    : 'bg-gray-300'
                                        }`}
                                    />
                                ))}
                            </div>

                            <Button
                                onClick={handleNext}
                                disabled={isLastSlide}
                                className="px-6 py-3 bg-red-600 hover:bg-red-700 text-white disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                Next →
                            </Button>
                        </div>

                        {/* Slide Counter */}
                        <div className="text-center mt-4 text-gray-500 text-sm">
                            Slide {currentSlide + 1} of {slides.length}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}