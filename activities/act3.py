class Character:
    def __init__(self, name, health, strength):
        self.name = name
        self.health = health
        self.strength = strength

class Warrior(Character):
    def __init__(self, name, health, strength):
        super().__init__(name, health, strength)
    
    def display_stats(self):
        print("\n=== WARRIOR STATS ===")
        print(f"Name: {self.name}")
        print(f"Health: {self.health}")
        print(f"Strength: {self.strength}")

print("Create your warrior character!")
name = input("Enter your character's name: ")
health = int(input("Enter starting health: "))
strength = int(input("Enter strength value: "))

warrior = Warrior(name, health, strength)
warrior.display_stats()
