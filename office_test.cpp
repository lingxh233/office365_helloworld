// unicode test.cpp : 此文件包含 "main" 函数。程序执行将在此处开始并结束。
//

#include <iostream>
using namespace std;

int main()
{
	cout << "hello world "<< endl;
	//输出当前时间
	cout << "当前时间：" << __DATE__ << " " << __TIME__ << endl;
	//输出unix时间戳
	cout << "unix时间戳：" << __TIME__ << endl;
}

