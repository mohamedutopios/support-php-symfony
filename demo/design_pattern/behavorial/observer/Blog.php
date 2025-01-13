<?php

require_once 'SubjectInterface.php';

class Blog implements SubjectInterface
{
    private array $observers = [];
    private string $latestPost;

    public function attach(ObserverInterface $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(ObserverInterface $observer): void
    {
        $this->observers = array_filter($this->observers, fn($obs) => $obs !== $observer);
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update("New blog post: {$this->latestPost}");
        }
    }

    public function publish(string $postTitle): void
    {
        $this->latestPost = $postTitle;
        $this->notify();
    }
}
