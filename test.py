import sys

string1 = sys.stdin.readline().strip()
string2 = sys.stdin.readline().strip()

m = len(string1)
n = len(string2)
b = [[0 for i in range(1000)] for i in range(1000)]
c = [[0 for i in range(1000)] for i in range(1000)]

ret = []

def LCSLength(x,y,m,n,c,b):
	i,j = 0,0
	for i in range(m+1):
		c[i][0] = 0
	for j in (1,n+1):
		c[0][j] = 0
	for i in range(1,m+1):
		for j in range(1,n+1):
			if x[i-1]==y[j-1]:
				c[i][j] = c[i-1][j-1]+1
				b[i][j] = 0
			elif c[i-1][j]>=c[i][j-1]:
				c[i][j] = c[i-1][j]
				b[i][j] = 1
			else:
				c[i][j] = c[i][j-1]
				b[i][j] = -1

def PrintLCS(b,x,i,j):
	if i==0 or j==0:
		return
	if b[i][j]==0:
		PrintLCS(b,x,i-1,j-1)
		ret.append(x[i-1])
	elif b[i][j]==1:
		PrintLCS(b,x,i-1,j)
	else:
		PrintLCS(b,x,i,j-1)


LCSLength(list(string1),list(string2),m,n,c,b)
PrintLCS(b,list(string1),m,n)
print(len(ret))