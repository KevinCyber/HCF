<?php

namespace iquopt\team;

class Team {
    public function __construct(
        private string $name,
        private string $leader,
        private array $members = [],
        private float $dtr = 1.1
    ) {}

    public function getName(): string {
        return $this->name;
    }

    public function getLeader(): string {
        return $this->leader;
    }

    public function setLeader(string $leader): void {
        $this->leader = $leader;
    }

    public function getMembers(): array {
        return $this->members;
    }

    public function addMember(string $player): void {
        if (!in_array($player, $this->members) && $player !== $this->leader) {
            $this->members[] = $player;
        }
    }

    public function removeMember(string $player): void {
        $this->members = array_filter($this->members, fn($m) => $m !== $player);
    }

    public function isMember(string $player): bool {
        return in_array($player, $this->members) || $this->leader === $player;
    }

    public function getDTR(): float {
        return $this->dtr;
    }

    public function setDTR(float $dtr): void {
        $this->dtr = $dtr; 
    }

    public function addDTR(float $amount): void {
        $this->dtr += $amount;
    }

    public function subtractDTR(float $amount): void {
        $this->dtr -= $amount; 
    }

    public function isRaidable(): bool {
        return $this->dtr < 0.0;
    }

    public function toArray(): array {
        return [
            "name" => $this->name,
            "leader" => $this->leader,
            "members" => $this->members,
            "dtr" => $this->dtr
        ];
    }

    public static function fromArray(array $data): Team {
        return new Team(
            $data["name"],
            $data["leader"],
            $data["members"] ?? [],
            $data["dtr"] ?? 1.1
        );
    }
}
