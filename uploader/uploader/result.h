#pragma once

#include <string>

struct Result {
	std::string lastname, firstname, club,category;
	int finish, start, time;
	//unsigned short place;
	unsigned char status;
	int check[64];
	unsigned char checknr[64];
	Result() {
		for (int i = 0; i < 64; i++) {
			check[i] = 0;
			checknr[i] = 0;
		}
	}
};