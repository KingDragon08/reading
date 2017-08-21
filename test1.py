import sys

N = int(sys.stdin.readline().strip())
data1 = [int(i) for i in sys.stdin.readline().strip().split(" ")]
M = int(sys.stdin.readline().strip())
data2 = [int(i) for i in sys.stdin.readline().strip().split(" ")]

avg1 = float(sum(data1))/len(data1)
avg2 = float(sum(data2))/len(data2)

ret = 0
for i in data2:
	if i>avg1 and i<avg2:
		ret += 1

print(ret)