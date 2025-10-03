<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web System Architecture & Design Patterns</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #1a1a2e;
            color: #e0e0e0;
        }
        .slide-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
            text-align: center;
        }
        .slide {
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 2rem;
            opacity: 0;
            transition: opacity 0.7s ease-in-out;
        }
        .slide.active {
            display: flex;
            opacity: 1;
        }
        .diagram {
            background-color: #24243e;
            border: 2px solid #5a5a7f;
            padding: 1.5rem;
            margin-top: 2rem;
            border-radius: 1rem;
            text-align: left;
        }
        .diagram h3 {
            color: #ffd700;
        }
        .diagram p {
            margin-bottom: 0.5rem;
        }
        .diagram .box {
            background-color: #3b3b5c;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            color: white;
            font-weight: 600;
        }
        .diagram .arrow {
            color: #8c8cd4;
            font-weight: bold;
        }
        pre {
            background-color: #2b2b4d;
            border: 1px solid #4a4a6e;
            color: #e0e0e0;
            padding: 1rem;
            border-radius: 0.5rem;
            font-family: 'Courier New', Courier, monospace;
            white-space: pre-wrap;
            word-wrap: break-word;
            text-align: left;
            margin-top: 1rem;
            width: 100%;
        }
    </style>
</head>
<body class="bg-[#1a1a2e] text-white">

    <div id="presentation-container" class="slide-container">
        
        <!-- Slide 1: Title Slide -->
        <div id="slide-1" class="slide active">
            <h1 class="text-5xl md:text-6xl font-extrabold mb-4 text-[#ffd700]">Web System Architecture & Design Patterns</h1>
            <p class="text-xl md:text-2xl text-gray-300 mb-8">Building Scalable and Maintainable Systems</p>
			</div>

        <!-- Slide 2: What is Web System Architecture? -->
        <div id="slide-2" class="slide">
            <h2 class="text-3xl md:text-4xl font-bold mb-6 text-[#ffd700]">What is Web System Architecture?</h2>
            <div class="text-left max-w-4xl">
                <p class="mb-4 text-lg">Web system architecture defines the high-level structure of a web application. It's the blueprint that determines how all the components—from the front-end to the database—are organized and how they communicate with each other.</p>
                <p class="mb-4 text-lg">The primary goals of a good architecture are to ensure the system is:</p>
                <ul class="list-disc list-inside space-y-2 text-lg">
                    <li><span class="font-semibold text-white">Scalable:</span> Can handle increasing numbers of users and data without a performance hit.</li>
                    <li><span class="font-semibold text-white">Maintainable:</span> Easy to fix, update, and add new features.</li>
                    <li><span class="font-semibold text-white">Performant:</span> Fast and responsive for the end user.</li>
                    <li><span class="font-semibold text-white">Resilient:</span> Can handle failures without going down completely.</li>
                </ul>
            </div>
        </div>

        <!-- Slide 3: Monolithic Architecture -->
        <div id="slide-3" class="slide">
            <h2 class="text-3xl md:text-4xl font-bold mb-6 text-[#ffd700]">Monolithic Architecture</h2>
            <div class="text-left max-w-4xl">
                <p class="mb-4 text-lg">A monolith is a single, unified codebase where all components (front-end, back-end, business logic, etc.) are tightly coupled and deployed together as one single unit.</p>
                <div class="diagram mt-6 p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-2 text-yellow-400">Conceptual Diagram:</h3>
                    <div class="flex items-center justify-center space-x-4">
                        <div class="box">Client Request</div>
                        <div class="arrow text-2xl">➔</div>
                        <div class="box">Monolith Application</div>
                        <div class="arrow text-2xl">➔</div>
                        <div class="box">Database</div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row space-y-8 md:space-y-0 md:space-x-8 mt-8 w-full">
                    <div class="w-full md:w-1/2">
                        <h4 class="text-2xl font-semibold text-white mb-2">Pros:</h4>
                        <ul class="list-disc list-inside space-y-2 text-lg">
                            <li>Simple to develop and deploy.</li>
                            <li>Easier to test.</li>
                            <li>No network latency between components.</li>
                        </ul>
                    </div>
                    <div class="w-full md:w-1/2">
                        <h4 class="text-2xl font-semibold text-white mb-2">Cons:</h4>
                        <ul class="list-disc list-inside space-y-2 text-lg">
                            <li>Hard to scale parts of the application independently.</li>
                            <li>A bug in one part can bring down the whole system.</li>
                            <li>Difficult to work on in large teams.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 4: Monolithic Architecture Example -->
        <div id="slide-4" class="slide">
            <h2 class="text-3xl md:text-4xl font-bold mb-6 text-[#ffd700]">Monolithic Architecture Example</h2>
            <div class="text-left max-w-4xl">
                <p class="mb-4 text-lg">An e-commerce monolith would have all features in a single codebase. A simple folder structure might look like this:</p>
                <pre>
/E-Commerce
  /src
    /controllers
      /UserController.js
      /ProductController.js
      /OrderController.js
    /services
      /UserService.js
      /ProductService.js
      /OrderService.js
    /models
      /User.js
      /Product.js
      /Order.js
    /routes.js
  /database
    /migrations
  /views
    /user
    /product
    /order
                </pre>
            </div>
        </div>

        <!-- Slide 5: Microservices Architecture -->
        <div id="slide-5" class="slide">
            <h2 class="text-3xl md:text-4xl font-bold mb-6 text-[#ffd700]">Microservices Architecture</h2>
            <div class="text-left max-w-4xl">
                <p class="mb-4 text-lg">Microservices break down a single application into a suite of small, independent services, each running in its own process and communicating via APIs.</p>
                <div class="diagram mt-6 p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-2 text-yellow-400">Conceptual Diagram:</h3>
                    <div class="flex flex-col items-center justify-center space-y-2">
                        <div class="box">Client Request</div>
                        <div class="arrow text-2xl">↓</div>
                        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                            <div class="box">Service A</div>
                            <div class="box">Service B</div>
                            <div class="box">Service C</div>
                        </div>
                        <div class="arrow text-2xl">↓</div>
                        <div class="box">Database(s)</div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row space-y-8 md:space-y-0 md:space-x-8 mt-8 w-full">
                    <div class="w-full md:w-1/2">
                        <h4 class="text-2xl font-semibold text-white mb-2">Pros:</h4>
                        <ul class="list-disc list-inside space-y-2 text-lg">
                            <li>Highly scalable and resilient.</li>
                            <li>Each service can be developed and deployed independently.</li>
                            <li>Easier for large teams to work in parallel.</li>
                        </ul>
                    </div>
                    <div class="w-full md:w-1/2">
                        <h4 class="text-2xl font-semibold text-white mb-2">Cons:</h4>
                        <ul class="list-disc list-inside space-y-2 text-lg">
                            <li>More complex to develop and manage.</li>
                            <li>Distributed data can be challenging.</li>
                            <li>Network latency between services.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 6: Microservices Architecture Example -->
        <div id="slide-6" class="slide">
            <h2 class="text-3xl md:text-4xl font-bold mb-6 text-[#ffd700]">Microservices Architecture Example</h2>
            <div class="text-left max-w-4xl">
                <p class="mb-4 text-lg">An e-commerce microservices system would separate features into independent services. This is reflected in the folder structure:</p>
                <pre>
/E-Commerce
  /User-Service
    /src
      /controllers
      /services
      /models
  /Product-Service
    /src
      /controllers
      /services
      /models
  /Order-Service
    /src
      /controllers
      /services
      /models
  /Gateway (API Gateway)
    /src
      /routes.js
                </pre>
            </div>
        </div>
        
        <!-- Slide 7: Common Web Design Patterns -->
        <div id="slide-7" class="slide">
            <h2 class="text-3xl md:text-4xl font-bold mb-6 text-[#ffd700]">Common Web Design Patterns</h2>
            <div class="text-left max-w-4xl">
                <p class="mb-4 text-lg">Design patterns are reusable solutions to common problems in software design. They are not a final solution, but rather a template that can be applied in different situations.</p>
                <p class="text-lg">They help developers create code that is more organized, flexible, and easier to understand, especially in a team environment.</p>
            </div>
        </div>

        <!-- Slide 8: Model-View-Controller (MVC) -->
        <div id="slide-8" class="slide">
            <h2 class="text-3xl md:text-4xl font-bold mb-6 text-[#ffd700]">Model-View-Controller (MVC)</h2>
            <div class="text-left max-w-4xl">
                <p class="mb-4 text-lg">The MVC pattern separates an application into three interconnected components, improving modularity and organization.</p>
                <div class="diagram mt-6 p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-2 text-yellow-400">The Components:</h3>
                    <ul class="list-disc list-inside space-y-2 text-lg">
                        <li><span class="font-semibold text-white">Model:</span> Manages the application's data, logic, and rules. It holds the "what."</li>
                        <li><span class="font-semibold text-white">View:</span> The user interface. It is responsible for presenting data to the user.</li>
                        <li><span class="font-semibold text-white">Controller:</span> The intermediary. It handles user input, updates the Model, and selects the correct View to display.</li>
                    </ul>
                </div>
                <div class="diagram mt-6 p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-2 text-yellow-400">Flow of a Request:</h3>
                    <p class="text-sm">Client Request ➔ Controller ➔ Model ➔ View ➔ Client Response</p>
                </div>
            </div>
        </div>
        
        <!-- Slide 9: MVC Example (Laravel) -->
        <div id="slide-9" class="slide">
            <h2 class="text-3xl md:text-4xl font-bold mb-6 text-[#ffd700]">MVC Example (Laravel)</h2>
            <div class="text-left max-w-4xl">
                <p class="mb-4 text-lg">A simple Laravel example for a product management system. Note that the Model is typically a single class file, and the Controller is a single class file.</p>
                <h4 class="text-xl font-semibold text-white mb-2">Model (app/Models/Product.php):</h4>
                <pre>
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // The model automatically connects to the 'products' table.
    // We can define relationships or custom methods here.
    public function getStockStatus()
    {
        return $this->stock > 0 ? 'In Stock' : 'Out of Stock';
    }
}
                </pre>
                <h4 class="text-xl font-semibold text-white mb-2">Controller (app/Http/Controllers/ProductController.php):</h4>
                <pre>
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        // 1. Controller calls the Model to get data
        $products = Product::all();
        
        // 2. Controller sends the data to the View
        return view('products.index', ['products' => $products]);
    }
}
                </pre>
            </div>
        </div>

        <!-- Slide 10: The Repository Pattern -->
        <div id="slide-10" class="slide">
            <h2 class="text-3xl md:text-4xl font-bold mb-6 text-[#ffd700]">The Repository Pattern</h2>
            <div class="text-left max-w-4xl">
                <p class="mb-4 text-lg">This pattern abstracts the data access logic. Instead of a controller directly interacting with the database, it interacts with a "repository."</p>
                <p class="mb-4 text-lg">This makes your code independent of the specific database technology. You could switch from MySQL to PostgreSQL without changing your business logic.</p>
                <div class="diagram mt-6 p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-2 text-yellow-400">Conceptual Diagram:</h3>
                    <div class="flex flex-col items-center space-y-4">
                        <div class="box">Controller</div>
                        <div class="arrow text-2xl">↓</div>
                        <div class="box">Repository</div>
                        <div class="arrow text-2xl">↓</div>
                        <div class="box">Database</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 11: Repository Pattern Example (Laravel) -->
        <div id="slide-11" class="slide">
            <h2 class="text-3xl md:text-4xl font-bold mb-6 text-[#ffd700]">Repository Pattern Example</h2>
            <div class="text-left max-w-4xl">
                <p class="mb-4 text-lg">A Laravel example for an `OrderRepository` that handles all database operations:</p>
                <h4 class="text-xl font-semibold text-white mb-2">Interface (app/Repositories/OrderRepositoryInterface.php):</h4>
                <pre>
namespace App\Repositories;

use App\Models\Order;

interface OrderRepositoryInterface
{
    public function findById(int $id): ?Order;
    public function save(Order $order): void;
    public function updateStatus(int $id, string $status): void;
}
                </pre>
                <h4 class="text-xl font-semibold text-white mb-2">Class (app/Repositories/OrderRepository.php):</h4>
                <pre>
namespace App\Repositories;

use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public function findById(int $id): ?Order
    {
        return Order::find($id);
    }
    
    public function save(Order $order): void
    {
        $order->save();
    }
    
    public function updateStatus(int $id, string $status): void
    {
        $order = $this->findById($id);
        if ($order) {
            $order->status = $status;
            $order->save();
        }
    }
}
                </pre>
                <h4 class="text-xl font-semibold text-white mb-2">Controller (app/Http/Controllers/OrderController.php):</h4>
                <pre>
namespace App\Http\Controllers;

use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderRepository;

    // Use dependency injection to get the repository
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function show($id)
    {
        $order = $this->orderRepository->findById($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $order = $this->orderRepository->findById($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->status = $request->input('status');
        $this->orderRepository->save($order);

        return response()->json($order);
    }
}
                </pre>
            </div>
        </div>

        <!-- Slide 12: Dependency Injection (DI) and Registration -->
        <div id="slide-12" class="slide">
            <h2 class="text-3xl md:text-4xl font-bold mb-6 text-[#ffd700]">DI & Registration with a Service Provider</h2>
            <div class="text-left max-w-4xl">
                <p class="mb-4 text-lg">For the controller to receive the repository, we need to tell the framework's **Service Container** how to "bind" the interface to its concrete implementation. This is typically done in a **Service Provider**.</p>
                <p class="mb-4 text-lg">The `bind` method says: "When a class needs the `OrderRepositoryInterface`, give it an instance of `OrderRepository`."</p>
                <h4 class="text-xl font-semibold text-white mb-2">Service Provider (app/Providers/RepositoryServiceProvider.php):</h4>
                <pre>
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\OrderRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    // The framework calls the register() method.
    public function register()
    {
        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );
    }
}
                </pre>
            </div>
        </div>

        <!-- Slide 13: The Service Pattern -->
        <div id="slide-13" class="slide">
            <h2 class="text-3xl md:text-4xl font-bold mb-6 text-[#ffd700]">The Service Pattern</h2>
            <div class="text-left max-w-4xl">
                <p class="mb-4 text-lg">A service is a class or component that encapsulates a specific piece of business logic. The controller calls a service, which in turn performs the necessary operations (e.g., calling a repository).</p>
                <p class="mb-4 text-lg">This keeps controllers "thin" and focused on handling HTTP requests, promoting the Single Responsibility Principle.</p>
                <div class="diagram mt-6 p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-2 text-yellow-400">Conceptual Diagram:</h3>
                    <div class="flex flex-col items-center space-y-4">
                        <div class="box">Controller</div>
                        <div class="arrow text-2xl">↓</div>
                        <div class="box">Service</div>
                        <div class="arrow text-2xl">↓</div>
                        <div class="box">Repository</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 14: Service Pattern Example (Laravel) -->
        <div id="slide-14" class="slide">
            <h2 class="text-3xl md:text-4xl font-bold mb-6 text-[#ffd700]">Service Pattern Example</h2>
            <div class="text-left max-w-4xl">
                <p class="mb-4 text-lg">A service class that handles the complex logic for creating an order:</p>
                <h4 class="text-xl font-semibold text-white mb-2">Service (app/Services/OrderService.php):</h4>
                <pre>
namespace App\Services;

use App\Models\Order;
use App\Repositories\OrderRepositoryInterface;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function createOrder(array $items, int $userId): Order
    {
        // Complex business logic: calculate total, apply discounts, validate stock
        // For simplicity, we'll just create a new order model
        $newOrder = new Order(['items' => $items, 'user_id' => $userId]);
        $this->orderRepository->save($newOrder);
        return $newOrder;
    }
}
                </pre>
                <h4 class="text-xl font-semibold text-white mb-2">Controller (app/Http/Controllers/OrderController.php):</h4>
                <pre>
namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(Request $request)
    {
        try {
            // Controller only calls the service and handles HTTP request/response
            $newOrder = $this->orderService->createOrder($request->items, $request->user_id);
            return response()->json($newOrder, 201);
        } catch (\Exception $error) {
            return response()->json(['error' => 'Failed to create order'], 500);
        }
    }
}
                </pre>
            </div>
        </div>

        <!-- Slide 15: Conclusion -->
        <div id="slide-15" class="slide">
            <h2 class="text-4xl font-bold mb-6 text-[#ffd700]">Key Takeaways</h2>
            <div class="text-left max-w-4xl">
                <ul class="list-disc list-inside space-y-4 text-lg">
                    <li><span class="font-semibold text-white">Architecture is the blueprint:</span> It's the high-level plan that dictates how your system will be built.</li>
                    <li><span class="font-semibold text-white">Choose the right tool for the job:</span> Both monolithic and microservices architectures have their place.</li>
                    <li><span class="font-semibold text-white">Patterns are your guide:</span> Design patterns provide tested, reusable solutions that make your code more robust and understandable.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="fixed bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-4">
        <button id="prev-btn" class="bg-[#5a5a7f] hover:bg-[#7a7a9f] text-white font-bold py-3 px-6 rounded-full transition-colors duration-300 shadow-lg">
            Previous
        </button>
        <button id="next-btn" class="bg-[#e74c3c] hover:bg-[#c0392b] text-white font-bold py-3 px-6 rounded-full transition-colors duration-300 shadow-lg">
            Next
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slides = document.querySelectorAll('.slide');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');
            let currentSlide = 0;

            function showSlide(index) {
                slides.forEach((slide, i) => {
                    slide.classList.remove('active');
                    if (i === index) {
                        slide.classList.add('active');
                    }
                });
                updateButtons();
            }

            function updateButtons() {
                prevBtn.disabled = currentSlide === 0;
                nextBtn.disabled = currentSlide === slides.length - 1;
                prevBtn.style.opacity = prevBtn.disabled ? '0.5' : '1';
                nextBtn.style.opacity = nextBtn.disabled ? '0.5' : '1';
            }

            prevBtn.addEventListener('click', () => {
                if (currentSlide > 0) {
                    currentSlide--;
                    showSlide(currentSlide);
                }
            });

            nextBtn.addEventListener('click', () => {
                if (currentSlide < slides.length - 1) {
                    currentSlide++;	
                    showSlide(currentSlide);
                }
            });

            showSlide(currentSlide);
        });
    </script>

</body>
</html>