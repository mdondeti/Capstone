package Tests;

import static org.testng.Assert.assertEquals;
import static org.testng.Assert.assertTrue;
import static org.testng.Assert.fail;

import java.io.FileInputStream;
import java.sql.Driver;
import java.util.ArrayList;
import java.util.List;

import org.testng.asserts.*;
import org.apache.commons.lang3.StringUtils;
import org.apache.poi.ss.usermodel.CellType;
import org.apache.poi.ss.usermodel.DataFormatter;
import org.apache.poi.xssf.usermodel.XSSFCell;
import org.apache.poi.xssf.usermodel.XSSFRow;
import org.apache.poi.xssf.usermodel.XSSFSheet;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;
import org.junit.BeforeClass;
import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.Select;
import org.testng.annotations.*;
import Repos.RegisterPage;
import Repos.vitalSignsSectionPage;
import Repos.vitalSignsSectionPage;
import Repos.AddNewPatientPage;
import Repos.DemographicsPage;
import Repos.LoginPage;

public class DemographicsTest {
	WebDriver driver ;

	static XSSFWorkbook workBook; 
	static XSSFSheet sheet;
	static XSSFRow row;
	static int i=0;
	static int j=0;
	static Object[][] DataCellValues;





	@DataProvider(name="demographics")
	//@Test
	public static Object[][] dataInputFromExcel() throws Exception
	{
		FileInputStream fs = new FileInputStream("C:\\\\Users\\\\astri\\\\Desktop\\\\logindata.xlsx");
		workBook = new XSSFWorkbook(fs);
		sheet = workBook.getSheet("Demo");

		int k=sheet.getLastRowNum();//get the number of rows

		int l=sheet.getRow(0).getLastCellNum();//get the number of columns in first row

		//define a string type two dimensional array
		DataCellValues = new Object[k+1][l];
		for(i=0;i<=k;i++)
		{
			row= sheet.getRow(i);
			for(j=0;j<l-1;j++)
			{
				XSSFCell cell= row.getCell(j);	
				if(row.getCell(j)==null)
				{
					DataCellValues[i][j]="";
				}
				else
				{
					DataCellValues[i][j]= new DataFormatter().formatCellValue(row.getCell(j));
				}


			}
		}
		return DataCellValues;

	}


	String PatientName = "";
	String VisitDate = "";
	String sex;
	private String age;
	private String heightUnit;
	private String height;
	private String weight;
	private String weightUnit;



	@Test(dataProvider="demographics")
	public void test(String Uname,String password,String Patient,String ERoomNo,String Eage, String Eheight, String Eweight,String EweightUnit,String EHeightUnit,String value) throws Exception
	{
		driver = new FirefoxDriver();

		LoginPage.GoToPage(driver);
		LoginPage.UserName(driver).sendKeys(Uname);
		LoginPage.Password(driver).sendKeys(password);
		LoginPage.Submit(driver).click();
		driver.findElement(By.partialLinkText(Patient)).click();
		PatientName = DemographicsPage.name(driver).getText();
		VisitDate= DemographicsPage.date(driver).getText();
		if(DemographicsPage.maleRadio(driver).isSelected())
		{
			sex="Male";
		}
		else
		{
			sex="Female";
		}
		age=DemographicsPage.age(driver).getText();
		height=DemographicsPage.height(driver).getText();
		Select hu = new Select(DemographicsPage.heightUnit(driver));
		heightUnit=hu.getFirstSelectedOption().getText();
		weight=DemographicsPage.weight(driver).getText();
		Select wu = new Select(DemographicsPage.weightUnit(driver));
		weightUnit=wu.getFirstSelectedOption().getText();
		String room = DemographicsPage.roomnumber(driver).getText();
		System.out.println(room);
				
		
		System.out.println(sex);
		//pass values
		
		
		DemographicsPage.name(driver).sendKeys("janeDoe");
		DemographicsPage.date(driver).sendKeys("2017-0-0-");
		
		//check name and visitdate cannot be changed
		assertEquals(DemographicsPage.name(driver).getText(), PatientName);
		assertEquals(DemographicsPage.date(driver).getText(), VisitDate);
		//check height and weight
	
		DemographicsPage.age(driver).clear();
		DemographicsPage.height(driver).clear();
		DemographicsPage.weight(driver).clear();
		System.out.println("got here pass values");
		//DemographicsPage.roomnumber(driver).clear();
		DemographicsPage.age(driver).sendKeys(Keys.BACK_SPACE);
		DemographicsPage.age(driver).sendKeys(Eage);
		DemographicsPage.height(driver).sendKeys(Eheight);
		DemographicsPage.weight(driver).sendKeys(Eweight);
		Thread.sleep(5000);
		//DemographicsPage.roomnumber(driver).sendKeys(ERoomNo);
		Select se=new Select(DemographicsPage.heightUnit(driver));
		se.selectByValue(EHeightUnit);
		Select se1=new Select(DemographicsPage.weightUnit(driver));
		se1.selectByValue(EweightUnit);
		if(sex=="Male")
		{
			DemographicsPage.femaleRadio(driver).click();
		}
		else
		{
			DemographicsPage.maleRadio(driver).click();
		}
		
		
		Thread.sleep(5000);
		DemographicsPage.saveButton(driver).click();
		
		

		//check what happens if age heiht or weight has no value
		if(Eage.isEmpty()||Eheight.isEmpty()||Eweight.isEmpty()||ERoomNo.isEmpty())
		{
			System.out.println("got inside o");
			

			assertEquals(DemographicsPage.name(driver).getText(),Patient);
		}
		else
		{
			System.out.println("got inside here");


			
			
			//check if age is alpha
			try {
				int x = Integer.parseInt(Eage); 

				System.out.println("Valid input");
			}catch(NumberFormatException e) {
				System.out.println("age");
				assertEquals(DemographicsPage.alert(driver).isDisplayed(), true);

				//error message is displayed
				//assert
				assertEquals(DemographicsPage.age(driver).getText(), age);
				return;

			} 
			

			//check if height is alpha
			try {
				int x = Integer.parseInt(Eheight); 

				System.out.println("Valid input");
			}catch(NumberFormatException e) {
				System.out.println("Eheight");
				assertEquals(DemographicsPage.alert(driver).isDisplayed(), true);

				//error message is displayed
				//assert
				assertEquals(DemographicsPage.height(driver).getText(), height);
				return;

			} 
			
//			
//			//check if weight is alpha
			
			try {
				int x = Integer.parseInt(Eweight); 

				System.out.println("Valid input");
			}catch(NumberFormatException e) {
				System.out.println("Eweight");
				assertEquals(DemographicsPage.alert(driver).isDisplayed(), true);
				//error message is displayed
				//assert
				assertEquals(DemographicsPage.weight(driver).getText(), weight);
				return;

			} 
			

			//check if change is reflected in vital signs pane
			if(sex=="Male")
			{
				assertEquals(vitalSignsSectionPage.nameDemo(driver).getText().contains("Jane"), true);
				assertEquals(vitalSignsSectionPage.sexDemo(driver).getText(), "Female");
				assertEquals(DemographicsPage.name(driver).getText().contains("Jane"),true);
				
				
			}
			else
			{
				assertEquals(vitalSignsSectionPage.nameDemo(driver).getText().contains("John"), true);
				assertEquals(vitalSignsSectionPage.sexDemo(driver).getText(), "Male");
			}

			//check age
			


Thread.sleep(5000);
			

			System.out.println(DemographicsPage.height(driver).getText());
			System.out.println(Eheight);
			assertEquals(DemographicsPage.height(driver).getText(), Eheight);
			System.out.println("Valid input");
			assertEquals(DemographicsPage.weight(driver).getText(), Eweight);
			System.out.println("Valid input");
			assertEquals(DemographicsPage.age(driver).getText(), Eage);
				
			assertEquals(wu.getFirstSelectedOption().getText(), EweightUnit);
			assertEquals(hu.getFirstSelectedOption().getText(), EHeightUnit);







		}








driver.close();
	}







}
