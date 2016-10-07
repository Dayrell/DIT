#initial values
temp = 0
b = 1
c = 2

#counter
i = 3;


while temp < pow(10,999): # the first number with 1k numbers is 10^999
	#next fib number
    temp = b + c

    #new values to be added in next loop
    b = c
    c = temp

 	#increase counter
    i = i + 1

print (c, i)