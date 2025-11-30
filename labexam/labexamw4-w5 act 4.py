class Book:
    
    def __init__(self, title, author, publication_year): #initialize the book object
        self.title = title
        self.author = author
        self.publication_year = publication_year
        self.available = True  
    
    def borrow_book(self):
        if self.available:
            self.available = False
            print(f"\n✓ You have successfully borrowed '{self.title}'.")
        else:
            print(f"\n✗ Sorry, '{self.title}' is currently unavailable.")
    
    def return_book(self):   # imark ang book as returned (available).
        if not self.available:
            self.available = True
            print(f"\n✓ Thank you for returning '{self.title}'.")
        else:
            print(f"\n✗ '{self.title}' was not borrowed.")
    
    def is_available(self): #Check if the book is available.
        return self.available
    
    def display_info(self): #display
        status = "Available" if self.available else "Borrowed"
        print("\n" + "="*50)
        print("BOOK INFORMATION")
        print("="*50)
        print(f"Title:            {self.title}")
        print(f"Author:           {self.author}")
        print(f"Publication Year: {self.publication_year}")
        print(f"Status:           {status}")
        print("="*50)


def main():
    """Main function to run the library book management system."""
    print("="*50)
    print("   LIBRARY BOOK MANAGEMENT SYSTEM")
    print("="*50)
    
    #Ask how many books to add
    num_books = int(input("\nHow many books do you want to add? "))
    books = []
    
    #Add multiple books
    for i in range(num_books):
        print(f"\n--- Book {i+1} ---")
        title = input("Book Title: ")
        author = input("Author: ")
        publication_year = input("Publication Year: ")
        books.append(Book(title, author, publication_year))
    
    print(f"\n✓ Successfully added {num_books} book(s) to the library!")
    
    #Menu loop
    while True:
        print("\n" + "-"*50)
        print("MENU OPTIONS")
        print("-"*50)
        print("1. Display All Books")
        print("2. Borrow Book")
        print("3. Return Book")
        print("4. Check Availability")
        print("5. Exit")
        print("-"*50)
        
        choice = input("\nEnter your choice (1-5): ")
        
        if choice == "1":   #Display all books

            for i, book in enumerate(books, 1):
                print(f"\n--- Book {i} ---")
                book.display_info()
        
        elif choice == "2":  #Borrow a book

            print("\nAvailable books:")
            for i, book in enumerate(books, 1):
                status = "Available" if book.is_available() else "Borrowed"
                print(f"{i}. {book.title} - {status}")
            
            book_num = int(input("\nWhich book do you want to borrow? (Enter number): "))
            if 1 <= book_num <= len(books):
                books[book_num - 1].borrow_book()
            else:
                print("\n✗ Invalid book number.")
        
        elif choice == "3": #Return
            print("\nAll books:")
            for i, book in enumerate(books, 1):
                status = "Available" if book.is_available() else "Borrowed"
                print(f"{i}. {book.title} - {status}")
            
            book_num = int(input("\nWhich book do you want to return? (Enter number): "))
            if 1 <= book_num <= len(books):
                books[book_num - 1].return_book()
            else:
                print("\n✗ Invalid book number.")
        
        elif choice == "4":  #Check availability of all books
            print("\nBook Availability:")
            for i, book in enumerate(books, 1):
                status = "AVAILABLE" if book.is_available() else "BORROWED"
                print(f"{i}. '{book.title}' - {status}")
        
        elif choice == "5":
            print("\nThank you for using the Library Book Management System!")
            print("Goodbye!")
            break
        else:
            print("\n✗ Invalid choice. Please enter a number between 1 and 5.")


if __name__ == "__main__":
    main()
