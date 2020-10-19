# Weathers App
Provides weather data for a given city by proxying the requests to a third-party API using the provided key. 

# Dependencies
To run the project **docker** has to be installed on the machine, and the command line
you are using should be able to run **bash shell scripts**.

# Usage
Just run the **init.sh** bash script.

```console
foo@bar:~$ ./init.sh
```

The app is configured to run on port 8080, and should be 
reachable by URL: http://localhost:8080

# Caveats
- Symfony is configured to run in debug mode.
- Server makes requests to remote APIs