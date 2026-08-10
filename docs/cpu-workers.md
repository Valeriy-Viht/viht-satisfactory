# CPU Workers

A service designed for processing computationally intensive tasks using processor time.

## Goal

To ensure the processing of thousands of simultaneous requests for updating and recalculating different sizes of graphs while maintaining the relevance of the data.

## Key architectural solutions:

Tasks are performed in the __cooperative multitasking__ model. This allows you to:
- Minimize result delays to users
- Provide predictable response time
- Accelerate the completion of short tasks (with a small number of steps) without blocking long ones.

Processing takes place according to the __multiprocessor execution__ model. This allows you to:
- Recycle all processor cores and isolate the processing of independent requests.
- Provide multithreaded execution in a PHP environment.  

## Interaction

Tasks come from the backend service over a TCP socket and are distributed among child handler processes via ICP.