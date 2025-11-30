package activities;
class Item {
    String name;
    double price;
    int quantity;

    Item(String name, double price, int quantity) {
        this.name = name;
        this.price = price;
        this.quantity = quantity;
    }

    double gettotal() {
        return price * quantity;
    }
}

class Product extends Item {
    Product(String name, double price, int quantity) {
        super(name, price, quantity);
    }

    @Override
    double gettotal() {
        return price * quantity;
    }

    void displayReport() {
        System.out.println();
        System.out.println("Name: " + name);
        System.out.println("Price: " + price);
        System.out.println("Quantity: " + quantity);
        System.out.println("Total Cost: " + gettotal());
    }
}
A
public class nickler {
    public static void main(String[] args) {
        Product product = new Product(" ProMa X", 45000.0, 3);
        product.displayReport();
    }
}