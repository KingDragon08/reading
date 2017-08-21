import sys

n,m,k = [int(i) for i in sys.stdin.readline().strip().split(" ")]
data = [int(i) for i in sys.stdin.readline().strip().split(" ")]

i,counter,ret = 0,0,0
temp = []

while i<n:
	temp.append(max(data[(i/k)*k:(i/k+1)*k]))
	i += k

i=0

while i<=len(temp)-m:
	ret = max(ret,sum(temp[i:i+m]))
	i += 1

print(ret)

