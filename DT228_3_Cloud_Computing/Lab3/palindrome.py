def palindrome( string ):
    #invert string and save it in c
    c = string[::-1]

    #convert strings to upper case
    string = string.upper()
    c = c.upper()

    #return true or false
    return (c == string)

#User need to insert their string
string = raw_input("Insert string: ")
print (palindrome(string))
