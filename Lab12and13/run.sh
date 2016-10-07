#!/bin/bash

COL_BLUE="\x1b[34;01m"
COL_RESET="\x1b[39;49;00m"
echo -e $COL_BLUE"(Test 1) List all queues: (press enter)"$COL_RESET

read
echo ""

curl -s -X GET -H 'Accept: application/json' http://localhost:8080/queues | python -mjson.tool


##################################

echo ""

echo -e $COL_BLUE"(Test 2) Create queue (insert name)"$COL_RESET
read name


curl -s -X POST -H 'Content-Type:application/json' http://localhost:8080/create -d '{"name": "'$name'"}'

#############################################################################

echo ""

echo -e $COL_BLUE"(Test 3) Delete queue (insert name)"$COL_RESET
read name


curl -X DELETE -H 'Accept: application/json' http://localhost:8080/queues/$name

#############################################################################

echo ""  
          
echo -e $COL_BLUE"(Test 4) Count messages (insert name)"$COL_RESET
read name

             
curl -X GET -H 'Accept: application/json' http://localhost:8080/queues/$name/msgs/count

#############################################################################

echo ""  
          
echo -e $COL_BLUE"(Test 5) Insert message (insert name)"$COL_RESET
read name
echo -e $COL_BLUE"(insert message)"$COL_RESET
read message
    
             
curl -s -X POST -H 'Accept:application/json' http://localhost:8080/queues/$name/msgs -d '{"content": "'$message'"}'

#############################################################################



echo ""  
          
echo -e $COL_BLUE"(Test 6) Read messages (insert name)"$COL_RESET
read name
    
             
curl -X GET -H 'Accept: application/json' http://localhost:8080/queues/$name/msgs

########################################

echo ""  

echo -e $COL_BLUE"(Test 7) Delete messages (insert name)"$COL_RESET
read name


curl -X DELETE -H 'Accept: application/json' http://localhost:8080/queues/$name/msgs

########################################









