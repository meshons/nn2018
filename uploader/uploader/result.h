#pragma once

#include <string>

struct Result {
	std::string lastname, firstname, club,category;
	int id;
	int finish, start, time;
	//unsigned short place;
	unsigned char status;
	int check[64];
	unsigned char checknr[64];
	Result() {
		id = -1;
		for (int i = 0; i < 64; i++) {
			check[i] = 0;
			checknr[i] = 0;
		}
	}
	bool operator==(const Result &rhs)const {
		return (lastname == rhs.lastname && firstname == rhs.firstname && club == rhs.club && category == rhs.category);
	}
	bool operator<(const Result &rhs)const {
		bool ok = true;
		ok = (status == rhs.status && finish == rhs.finish && start == rhs.start && time == rhs.time);
		for (int i = 0; i < 64; i++)
			if (check[i] != rhs.check[i] || checknr[i] != rhs.checknr[i])
				ok = false;
		return !ok;
	}
};