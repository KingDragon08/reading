import sys

k = 19
num1 = 1
num2 = 1
i = 2
while i<k:
    num2 = num1 + num2
    num1 = num2 - num1
    i += 1
print(num2)